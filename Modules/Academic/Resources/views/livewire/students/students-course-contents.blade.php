<div class="accordion__menu">

    @foreach ($contents as $key => $content)

    @switch($content->content_type_id)

    @case(1)
    <!-- Videos -->
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-play-circle"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content->id]) }}">{{ $content->name }}</a>
        @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>
    @break

    @case(2)
    <!-- TEXTO -->
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-book-open"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content->id]) }}">{{ $content->name }}</a>
        @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>

    @break

    @case(3)
<!-- Archivos -->
    @if (substr($content->original_name, -4) =='.doc' ||
    substr($content->original_name, -5) =='.docx')
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-file-word"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('download_file', [$content->id, $student]) }}">{{ $content->name }}</a>
        @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>
    @endif
    @if (substr($content->original_name, -4) =='.xls' ||
    substr($content->original_name, -5) =='.xlsx')
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-file-excel"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('download_file', [$content->id, $student]) }}">{{ $content->name }}</a>
        @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>
    @endif
    @if (substr($content->original_name, -4) =='.pdf')
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-file-pdf"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content->id]) }}"">{{ $content->name }}</a>
         @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>
    @endif
    @break

    @case(4)
    <!-- Imagen -->
    <li class="accordion__menu-link">
        <span class="icon-16pt icon--left text-body"><i class="fa fa-image"></i></span>
        <a  style="font-size: 16px;" class="flex" href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content->id]) }}">{{ $content->name }}</a>
        @if ($content->completed)
        <span class="badge badge-orange">{{ __('labels.Viewed') }}</span>
        <span class="icon-16pt icon--right text-body"><i class="fa fa-check"></i></span>
        @endif
    </li>
    @break

    @endswitch




    @endforeach
</div>
