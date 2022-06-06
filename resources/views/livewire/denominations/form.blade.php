@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('type') <span class="text-danger er">{{ $message}}</span> @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <label >Value</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </span>
            </div>
            <input type="number" wire:model.lazy="value" class="form-control" placeholder="ej: 100" maxlength="25">
        </div>
        @error('value') <span class="text-danger er">{{ $message}}</span> @enderror
    </div>

    <div class="col-sm-12">
        <div class="form-group custom-file">
            <input type="file" wire:model="image" accept="image/x-png, image/gif, image/jpg" class="custom-file-input form-control">
            <label class="custom-file-label">
                Imagen {{$image}}
            </label>
            @error('image') <span class="text-danger er">{{ $message}}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')