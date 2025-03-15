<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    protected $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cards.index', [
            'cards' => $this->card->latest()->filter(request(['search']))->paginate(6)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Tambahkan validasi untuk image
        $validateRules = array_merge($this->card->validationRules(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Batasi ukuran 2MB
        ]);

        $validationMessage = $this->card->validationMessages();
        $data = $request->only(['title', 'description']);

        $val = Validator::make($request->all(), $validateRules, $validationMessage);
        if ($val->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $val->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cards', 'public');
        }

        $data['users_id'] = Auth::user()->id;
        $this->card->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Card created successfully',
            'redirect' => route('home')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return view('cards.show', [
            'card' => $card
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        return view('cards.edit', [
            'card' => $card
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        $validateRules = array_merge($this->card->validationRules(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Batasi ukuran 2MB
        ]);

        $validationMessage = $this->card->validationMessages();
        $data = $request->only(['title', 'description']);

        $val = Validator::make($request->all(), $validateRules, $validationMessage);
        if ($val->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $val->errors()
            ], 422);
        }

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cards', 'public');
        }

        $card->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Card updated successfully',
            'redirect' => route('home')
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json([
            'success' => true,
            'message' => 'Card deleted successfully',
            'redirect' => route('home')
        ]);
    }

    public function manage(){
        return view('cards.manage',[
            'cards' => Auth::user()->cards()->get()
        ]);
    }
}
