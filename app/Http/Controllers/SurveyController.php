<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SurveyController extends Controller
{
    /**
     * Menampilkan daftar survei milik user yang sedang login saja.
     */
    public function index(): View
    {
        // withCount('questions', 'responses') menghitung jumlah relasi dalam 1 query efisien
        $surveys = Auth::user()
            ->surveys()
            ->withCount(['questions', 'responses'])
            ->latest()
            ->paginate(10);

        return view('surveys.index', compact('surveys'));
    }

    /**
     * Menampilkan form pembuatan survei baru.
     */
    public function create(): View
    {
        return view('surveys.create');
    }

    /**
     * Menyimpan survei baru ke database.
     * Parameter otomatis tervalidasi oleh StoreSurveyRequest sebelum masuk ke method ini.
     */
    public function store(StoreSurveyRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Buat slug unik: contoh "Survei Kepuasan" -> "survei-kepuasan-a1b2c"
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(5));
        $validated['is_active'] = $request->boolean('is_active', true);

        // Simpan lewat relasi user() agar user_id otomatis terisi dengan ID user yang login
        $survey = Auth::user()->surveys()->create($validated);

        return redirect()
            ->route('surveys.show', $survey)
            ->with('success', 'Survei berhasil dibuat! Sekarang tambahkan pertanyaan.');
    }

    /**
     * Menampilkan detail survei & daftar pertanyaannya.
     */
    public function show(Survey $survey): View
    {
        // Panggil SurveyPolicy@view -> otomatis lempar error 403 jika bukan pemiliknya
        Gate::authorize('view', $survey);

        // Eager load relasi questions beserta options-nya agar tidak terjadi N+1 query
        $survey->load('questions.options');

        return view('surveys.show', compact('survey'));
    }

    /**
     * Menampilkan form edit survei.
     */
    public function edit(Survey $survey): View
    {
        Gate::authorize('update', $survey);

        return view('surveys.edit', compact('survey'));
    }

    /**
     * Memperbarui data survei di database.
     */
    public function update(UpdateSurveyRequest $request, Survey $survey): RedirectResponse
    {
        Gate::authorize('update', $survey);

        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $survey->update($validated);

        return redirect()
            ->route('surveys.index')
            ->with('success', 'Perubahan survei berhasil disimpan.');
    }

    /**
     * Menghapus survei beserta seluruh pertanyaan & jawabannya (via cascadeOnDelete).
     */
    public function destroy(Survey $survey): RedirectResponse
    {
        Gate::authorize('delete', $survey);

        $survey->delete();

        return redirect()
            ->route('surveys.index')
            ->with('success', 'Survei berhasil dihapus.');
    }
}