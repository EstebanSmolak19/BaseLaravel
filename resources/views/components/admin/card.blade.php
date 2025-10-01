<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-{{ $color }} shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{ $color }} text-uppercase mb-1">
                        {{ $label }}
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $number }}</div>
                        </div>
                        @if($progress !== null)
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-{{ $color }}" role="progressbar"
                                    style="width: {{ $progress }}%" 
                                    aria-valuenow="{{ $progress }}" 
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas {{ $icon }} fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>