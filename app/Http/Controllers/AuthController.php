<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Client;
use App\Models\Employee;

class AuthController extends Controller
{
    //returns the index page

    //validates the input, handles login request, and redirects the employee based on their role
    public function handleLogin(Request $request) {
        $credentials = $request->validate([
            'govt_email'=>'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['govt_email' => $credentials['govt_email'], 'password' => $credentials['password']])) {
            $request -> session() -> regenerate();

            $employee = Auth::user();

            if($employee->role === 'ROLE_ADMIN') {
                return redirect()->route('admin');
            }
            if($employee->role === 'ROLE_SUPERADMIN') {
                return redirect()->route('private.superadmin');
            }
            if($employee->role === 'ROLE_SURVEYOR') {
                return redirect()->route('private.surveyor');
            }

            return response()->json([
                'user' => [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'role' => $employee->role,
                ]
            ]);
        }

        return back()->withErrors([
            'govt_email' => 'Invalid email or password'
        ])->onlyInput('govt_email');
    }

    public function index() {
        return view('index');
    }

    public function admin() {
        $employee = Auth::user();
        $verificationBaseQuery = \App\Models\Client::query()
            ->whereNotNull('surveyed_by')
            ->orderByDesc('created_at');

        $verificationClients = (clone $verificationBaseQuery)
            ->where(function ($query) {
                $query->where('survey_status', 'pending')
                    ->orWhereNull('survey_status');
            })
            ->paginate(10)
            ->withQueryString();

        $returnedClients = (clone $verificationBaseQuery)
            ->where('survey_status', 'returned')
            ->paginate(10, ['*'], 'returned_page')
            ->withQueryString();

        $surveyorNames = \App\Models\Employee::query()
            ->whereIn('id', $verificationClients->getCollection()
                ->merge($returnedClients->getCollection())
                ->pluck('surveyed_by')
                ->filter()
                ->unique())
            ->get()
            ->mapWithKeys(fn ($surveyor) => [
                $surveyor->id => trim(implode(' ', array_filter([
                    $surveyor->first_name,
                    $surveyor->middle_name,
                    $surveyor->last_name,
                ]))),
            ]);
        $verificationStatusSource = (clone $verificationBaseQuery)->get();
        $verificationStatusCounts = [
            'pending' => $verificationStatusSource->filter(fn ($client) => ($client->survey_status ?? 'pending') === 'pending')->count(),
            'verified' => $verificationStatusSource->where('survey_status', 'verified')->count(),
            'returned' => $verificationStatusSource->where('survey_status', 'returned')->count(),
            'rejected' => $verificationStatusSource->where('survey_status', 'rejected')->count(),
        ];

        $surveyorLocations = $this->surveyorLocations();
        $adminClientMapPoints = $this->adminClientMapPoints();

        return view('private.admin.admin-dashboard', compact(
            'employee',
            'verificationClients',
            'returnedClients',
            'surveyorNames',
            'verificationStatusCounts',
            'surveyorLocations',
            'adminClientMapPoints'
        ));
    }

    public function surveyorLocationsApi()
    {
        return response()->json($this->surveyorLocations());
    }

    public function clientLocationsApi()
    {
        return response()->json($this->adminClientMapPoints());
    }

    public function superadmin() {
        $employees = \App\Models\Employee::all();
        return view('private.superadmin', compact('employees'));
    }

    public function surveyor() {
        $employee = Auth::user();
        return view('private.surveyor', compact('employee'));
    }

    public function form() {
        $employee = Auth::user();
        return view('private.form', compact('employee'));
    }

    public function surveyorDashboard() {
        $employee = Auth::user();
        return view('private.surveyor-dashboard', compact('employee'));
    }

    public function logout(Request $request) {
        $employee = Auth::user();

        if ($employee?->role === 'ROLE_SURVEYOR') {
            Employee::whereKey($employee->id)->update([
                'current_latitude' => null,
                'current_longitude' => null,
                'current_location_updated_at' => null,
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }

    private function surveyorLocations()
    {
        return Employee::query()
            ->where('role', 'ROLE_SURVEYOR')
            ->whereNotNull('current_latitude')
            ->whereNotNull('current_longitude')
            ->get([
                'id',
                'govt_id',
                'first_name',
                'middle_name',
                'last_name',
                'district',
                'current_latitude',
                'current_longitude',
                'current_location_updated_at',
            ])
            ->filter(fn ($surveyor) => is_numeric($surveyor->current_latitude) && is_numeric($surveyor->current_longitude))
            ->map(fn ($surveyor) => [
                'id' => $surveyor->id,
                'govt_id' => $surveyor->govt_id,
                'name' => trim(implode(' ', array_filter([
                    $surveyor->first_name,
                    $surveyor->middle_name,
                    $surveyor->last_name,
                ]))) ?: 'Unnamed Surveyor',
                'district' => $surveyor->district,
                'latitude' => (float) $surveyor->current_latitude,
                'longitude' => (float) $surveyor->current_longitude,
                'updated_at' => optional($surveyor->current_location_updated_at)->toIso8601String(),
            ])
            ->values();
    }

    private function adminClientMapPoints()
    {
        return Client::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get([
                'id',
                'client_id',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'category_of_client',
                'survey_status',
                'latitude',
                'longitude',
            ])
            ->filter(fn ($client) => is_numeric($client->latitude) && is_numeric($client->longitude))
            ->map(fn ($client) => [
                'id' => $client->id,
                'client_id' => $client->client_id,
                'name' => trim(implode(' ', array_filter([
                    $client->first_name,
                    $client->middle_name,
                    $client->last_name,
                    $client->suffix && $client->suffix !== '--N/A--' ? $client->suffix : null,
                ]))) ?: 'Unnamed Client',
                'category' => $client->category_of_client,
                'survey_status' => $client->survey_status ?? 'pending',
                'latitude' => (float) $client->latitude,
                'longitude' => (float) $client->longitude,
            ])
            ->values();
    }

}
