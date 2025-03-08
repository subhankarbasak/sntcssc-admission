<!-- resources/views/applications/partials/upsc_attempt.blade.php -->
<div class="upsc-attempt mb-3 p-3 border rounded position-relative">
    <input type="hidden" name="upsc_attempts[{{ $index }}][id]" value="{{ $attempt->id ?? '' }}">
    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 mt-2 me-2" 
            onclick="removeUpscAttempt(this)">
        <i class="fas fa-trash"></i>
    </button>
    <div class="row">
        <div class="col-md-3 mb-3">
            <input type="number" name="upsc_attempts[{{ $index }}][exam_year]" 
                   class="form-control" value="{{ old("upsc_attempts.$index.exam_year", $attempt->exam_year ?? '') }}" 
                   placeholder="Exam Year" min="2000" max="{{ date('Y') }}" required>
            @error("upsc_attempts.$index.exam_year")
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <input type="text" name="upsc_attempts[{{ $index }}][roll_number]" 
                   class="form-control" value="{{ old("upsc_attempts.$index.roll_number", $attempt->roll_number ?? '') }}" 
                   placeholder="Roll Number" required>
            @error("upsc_attempts.$index.roll_number")
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <div class="form-check">
                <input type="checkbox" name="upsc_attempts[{{ $index }}][prelims_cleared]" 
                       value="1" {{ old("upsc_attempts.$index.prelims_cleared", $attempt->prelims_cleared ?? false) ? 'checked' : '' }} 
                       class="form-check-input" id="prelims_{{ $index }}">
                <label class="form-check-label" for="prelims_{{ $index }}">Prelims Cleared</label>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="form-check">
                <input type="checkbox" name="upsc_attempts[{{ $index }}][mains_cleared]" 
                       value="1" {{ old("upsc_attempts.$index.mains_cleared", $attempt->mains_cleared ?? false) ? 'checked' : '' }} 
                       class="form-check-input" id="mains_{{ $index }}">
                <label class="form-check-label" for="mains_{{ $index }}">Mains Cleared</label>
            </div>
        </div>
    </div>
</div>