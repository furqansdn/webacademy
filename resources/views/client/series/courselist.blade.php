@foreach ($series->lessons as $item)
<div class="col-12">
    <div class="card lesson-list">
        <div class="card-body d-flex">
            <div class="col-1">
                <button disabled="disabled" class="btn btn-outline-primary"> {{$item->episode_number}} </button>
            </div>
            <div class="col-9 mt-1 ml-1">
                <h4 class="@if (Auth::user()->isLessonComplete($item->id))
                    {{'complete'}}
                @endif">{{ $item->title }}</h4>
            </div>
            <div class="col-2">
                @if (!Auth::user()->isSubscribed())
                    @if ($item->isPremium)
                        <span class="badge badge-primary">Paid</span>            
                    @else
                        <span class="badge badge-success">Free</span>
                    @endif
                @endif
                <a class="btn btn-outline-warning" href="{{ route('client::series.learning', [$series->slug, $item->id]) }}"><i class="fa fa-play-circle" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('style')
    <style>
        .primary-overlay {
            background: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);
        }

        .lesson-list {
            transition: transform 0.2s ease
        }
        .lesson-list:hover {
            transform: scale(1.05);
        }

        .complete {
            text-decoration: line-through;
            color: #b2bec3;
        }
    </style>
@endpush