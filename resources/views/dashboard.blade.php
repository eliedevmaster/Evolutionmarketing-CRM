@extends('layouts.theme')

@section('content-header')
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            @foreach (\App\Http\Helpers\DashboardNotificationHelper::get() as $notification)
                {!! $notification !!}
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header with-border">
                    <h4 class="pull-left">Inbox</h4>
                    <a href="#" class="archive-all-button pull-right">Archive All</a>
                </div>
                <div class="card-body">
                    @foreach ($notifications as $notification)
                        <div class="inbox-thread" data-notification-id={{ $notification['notification']->id }}>
                            <div class="inbox-thread-type">
                                <i class="{{ $notification['icon'] }}"></i>
                                <span class="text">{{ $notification['projectType'] }}<span>
                            </div>
                            <div class="inbox-thread-body">
                                <h5 class="description-text">{!! $notification['text'] !!}</h5>
                                <a href = "{{ $notification['targetLink'] }}" class="main-text" target="_blank">
                                    {{ $notification['targetText'] }}
                                </a>
                                @if( $notification['notification']->type == "complete job" && !is_null($notification['innerBlog']) )
                                    <h5 class="sub-text-in-list"><strong>Complete Urls</strong></h5>
                                    <ul class="website-list">
                                        @foreach ($notification['innerBlog']->website as $url)
                                            <li>
                                                <a href="{{ $url }}" target = "_blank">
                                                    {{ $url }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if( strlen($notification['innerBlog']->needed_text) > 0 )
                                        <h5 class="sub-text-in-list"><strong>Job Content</strong></h5>
                                    @endif
                                    {!! $notification['innerBlog']->needed_text !!}
                                @elseif( $notification['notification']->type == "complete blog" && !is_null($notification['blog']) )
                                    <h5 class="sub-text-in-list"><strong>Complete Urls</strong></h5>
                                    <ul class="website-list">
                                        <li>
                                            <a href="{{ $notification['blog']->blog_website }}" target = "_blank">
                                                {{ $notification['blog']->blog_website }}
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="archive-notification-button-wrapper">
                                <i class="archive-notification-button fas fa-times"></i>
                            </div>
                        </div>
                    @endforeach

                    @if( count($notifications) == 0 )
                        <h4 class="text-center">You don&rsquo;t have any new notifications.</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-header with-border bg-warning">
                    <h4 class="pull-left">Jobs within 7 days</h4>
                </div>
                <div class="card-body upcoming-jobs-wrapper">
                    @foreach ($upcomingJobs as $job)
                        <div class="inbox-thread">
                            <div class="inbox-thread-type">
                                <i class="fa fa-tasks"></i>
                                <span class="text">Jobs To Do
                            </div>
                            <div class="inbox-thread-body">
                                <h5 class="description-text">
                                    <a href="/jobs?editInnerBlogId={{ $job->id }}" target="_blank">
                                        {{ $job->title }}
                                    </a>
                                </h5>
                                <div class="due-date-field">
                                    Due Date : {{ (new \Carbon\Carbon($job->due_date))->format('m/d/y') }}
                                </div>
                                <div class="due-date-field">
                                    Assignee  : {{ $job->assignee()->name }}
                                </div>
                                @if( !empty($job->needed_text) )
                                    <h5 class="sub-text-in-list"><strong>Job Content</strong></h5>
                                    <p> {!! $job->needed_text !!} </p>
                                @endif
                            </div>
                            <div class="archive-notification-button-wrapper">
                            </div>
                        </div>
                    @endforeach

                    @if( count($upcomingJobs) == 0 )
                        <h4 class="text-center">You don&rsquo;t have any jobs to do within 7 days.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include("manage-client.modals.add-website")
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css?v=4') }}">
@endsection

@section('javascript')
    <script src="{{ asset('assets/js/website/website-add-edit-modal.js?v=7') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js?v=8') }}"></script>
@endsection
