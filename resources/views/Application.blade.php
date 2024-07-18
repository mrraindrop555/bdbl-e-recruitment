<x-layouts.guest>
    <form method="POST" action="{{ route('application', [$vacancy->id]) }}" class="row g-3">
        @csrf
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="inputEmail4">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">CID</label>
            <input type="number" name="cid" value="{{ old('cid') }}" class="form-control" id="inputEmail4">
            @error('cid')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputEmail5" class="form-label">Email</label>
            <input type="email" autocomplete="off" name="email" value="{{ old('email') }}" class="form-control"
                id="inputEmail5">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputPassword4" class="form-label">Marks</label>
            <input type="number" name="marks" value="{{ old('marks') }}" min="1" class="form-control"
                id="inputPassword4">
            @error('marks')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="modal-footer">
            <a href="/adminresult" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="background-color:red;border:none;color:white;padding:7px 40px;border-radius:2px;">close</a>
            <button type="submit" class="btn"
                style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Apply</button>
        </div>
    </form>
</x-layouts.guest>
