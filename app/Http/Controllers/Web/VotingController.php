<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\Vote;
use App\Models\Committee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function index(Request $request)
    {
        $query = Voting::with(['committee', 'position'])
            ->withCount('votes');

        if (in_array($request->status, ['open', 'closed'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('committee', fn ($c) => $c->where('full_name', 'like', "%{$search}%"))
                  ->orWhereHas('position', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $votings = $query->latest('start_date')->paginate(15)->withQueryString();

        foreach ($votings as $voting) {
            $yes = $voting->votes()->where('vote', 'yes')->count();
            $no  = $voting->votes()->where('vote', 'no')->count();

            $voting->yes_count   = $yes;
            $voting->no_count    = $no;
            $voting->total_votes = $yes + $no;
        }

        return view('votings.index', compact('votings'));
    }

    public function create()
    {
        $user = auth()->guard('web')->user();

        if (!$user || !$user->isSuperAdmin()) {
            return redirect()->route('votings.index')->with('error', 'Akses ditolak.');
        }

        $committees = Committee::where('active_status', 'active')->orderBy('full_name')->get();
        $positions  = Position::where('status', 'active')->orderBy('name')->get();

        return view('votings.create', compact('committees', 'positions'));
    }

    public function store(Request $request)
    {
        $user = auth()->guard('web')->user();

        if (!$user || !$user->isSuperAdmin()) {
            return redirect()->route('votings.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'position_id'  => 'required|exists:positions,id',
            'start_date'   => 'required|date|after_or_equal:today',
            'end_date'     => 'required|date|after:start_date',
            'description'  => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated) {
            Voting::create([
                ...$validated,
                'status' => 'open',
            ]);
        });

        return redirect()->route('votings.index')->with('success', 'Voting berhasil dibuat.');
    }

    public function show($id)
    {
        $voting = Voting::with(['committee', 'position', 'votes.committee'])
            ->withCount('votes')
            ->findOrFail($id);

        $user = auth()->guard('web')->user();
        $committee = $user?->committee;

        $userVote = $committee
            ? Vote::where('voting_id', $id)->where('committee_id', $committee->id)->first()
            : null;

        $votes = $voting->votes()->latest()->get();

        return view('votings.show', compact('voting', 'userVote', 'votes'));
    }

    public function vote(Request $request, $id)
    {
        $voting = Voting::findOrFail($id);

        if ($voting->status !== 'open') {
            return back()->with('error', 'Voting sudah ditutup.');
        }

        $user = auth()->guard('web')->user();
        $committee = $user?->committee;

        if (!$committee) {
            return back()->with('error', 'Hanya pengurus yang dapat memberikan suara.');
        }

        $validated = $request->validate([
            'vote'    => 'required|in:yes,no',
            'comment' => 'nullable|string|max:500',
        ]);

        Vote::create([
            'voting_id'    => $id,
            'committee_id' => $committee->id,
            'vote'         => $validated['vote'],
            'comment'      => $validated['comment'],
        ]);

        return back()->with('success', 'Suara berhasil dicatat.');
    }

    public function close($id)
    {
        $user = auth()->guard('web')->user();

        if (!$user || !$user->isSuperAdmin()) {
            return back()->with('error', 'Akses ditolak.');
        }

        Voting::where('id', $id)->update(['status' => 'closed']);

        return back()->with('success', 'Voting ditutup.');
    }
}
