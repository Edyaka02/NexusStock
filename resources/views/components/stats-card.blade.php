<div class="card text-white {{ $bg ?? 'bg-primary' }} mb-3">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <h6 class="card-title mb-0">{{ $title ?? 'Título' }}</h6>
      <p class="display-6 mb-0">{{ $value ?? '0' }}</p>
    </div>
    @if(isset($icon))
      <div class="fs-1 opacity-75">
        <i class="{{ $icon }}"></i>
      </div>
    @endif
  </div>
</div>