<?php

namespace App\Http\Controllers;

use App\Services\ConferenceService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected ConferenceService $conferenceService;
    protected UserService $userService;

    public function __construct(ConferenceService $conferenceService, UserService $userService)
    {
        $this->conferenceService = $conferenceService;
        $this->userService = $userService;
    }

    public function index()
    {
        $conferences = $this->conferenceService->getPlanned();
        
        return view('client.index', [
            'conferences' => $conferences,
        ]);
    }

    public function show($id)
    {
        $conference = $this->conferenceService->find($id);
        
        if (!$conference) {
            return redirect()->route('client.index')->with('error', 'Konferencija nerasta');
        }

        // For client view, we'll use a hardcoded user ID (1) - in real app this would come from auth
        $userId = 1;
        $isRegistered = $this->conferenceService->isUserRegistered($id, $userId);
        
        return view('client.show', [
            'conference' => $conference,
            'isRegistered' => $isRegistered,
        ]);
    }

    public function register($id)
    {
        $conference = $this->conferenceService->find($id);
        
        if (!$conference) {
            return redirect()->route('client.index')->with('error', 'Konferencija nerasta');
        }

        if ($conference['status'] !== 'planned') {
            return redirect()->route('client.show', $id)->with('error', 'Negalima registruotis į jau įvykusią konferenciją');
        }

        // For client view, we'll use a hardcoded user ID (1) - in real app this would come from auth
        $userId = 1;
        
        if ($this->conferenceService->isUserRegistered($id, $userId)) {
            return redirect()->route('client.show', $id)->with('error', 'Jūs jau užsiregistravote');
        }

        $this->conferenceService->registerUser($id, $userId);
        
        return redirect()->route('client.show', $id)->with('success', __('conferences.registered_success'));
    }
}

