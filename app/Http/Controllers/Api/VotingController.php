<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\Vote;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index(Request $request)
    {
        $query = Voting::with(['committee', 'position', 'votes'])
            ->withCount('votes');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $votings = $query->latest()->paginate(20);

        return ResponseHelper::paginated($request, $votings);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->isAdmin()) {
            return ResponseHelper::forbidden($request, 'Hanya admin yang dapat membuat voting');
        }

        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'position_id'  => 'required|exists:positions,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'description'  => 'nullable|string',
        ]);

        $voting = Voting::create([
            ...$validated,
            'status' => 'open',
        ]);

        return ResponseHelper::success(
            $request,
            $voting->load(['committee', 'position']),
            'Voting berhasil dibuat',
            201
        );
    }

    public function show(Request $request, $id)
    {
        $voting = Voting::with(['committee', 'position', 'votes.committee'])
            ->withCount('votes')
            ->findOrFail($id);

        return ResponseHelper::success($request, $voting);
    }

    public function castVote(Request $request, $id)
    {
        $voting = Voting::findOrFail($id);

        if ($voting->status !== 'open') {
            return ResponseHelper::error($request, 'Voting sudah ditutup', null, 422);
        }

        $validated = $request->validate([
            'vote'    => 'required|in:yes,no',
            'comment' => 'nullable|string',
        ]);

        $user = $request->user();
        $committee = $user?->committee;

        if (!$committee) {
            return ResponseHelper::forbidden($request, 'Hanya pengurus yang dapat memberikan suara');
        }

        $alreadyVoted = Vote::where('voting_id', $id)
            ->where('committee_id', $committee->id)
            ->exists();

        if ($alreadyVoted) {
            return ResponseHelper::error($request, 'Anda sudah memberikan suara', null, 422);
        }

        Vote::create([
            'voting_id'    => $id,
            'committee_id' => $committee->id,
            'vote'         => $validated['vote'],
            'comment'      => $validated['comment'],
        ]);

        if (now()->gt($voting->end_date)) {
            $voting->update(['status' => 'closed']);
        }

        return ResponseHelper::success($request, null, 'Suara berhasil dicatat');
    }

    public function close(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || !$user->isAdmin()) {
            return ResponseHelper::forbidden($request);
        }

        $voting = Voting::findOrFail($id);
        $voting->update(['status' => 'closed']);

        return ResponseHelper::success($request, $voting, 'Voting ditutup');
    }
}
