@extends('layouts.header_side')
@section('title', 'Профил')
@section('content')
      <div class="page-wrapper">
        <div class="page-header">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="avatar avatar-lg rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
              </div>
              <div class="col">
                <h1 class="fw-bold">{{Auth::user()->ime." ".Auth::user()->prezime}}</h1>
                <div class="my-2">Наставник
                </div>
                <div class="list-inline list-inline-dots text-muted">
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/map -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 -3l6 3l6 -3l0 13l-6 3l-6 -3l-6 3l0 -13" /><path d="M9 4l0 13" /><path d="M15 7l0 13" /></svg>
                    Модул рачунарска техника и информатика
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M3 7l9 6l9 -6" /></svg>
                    <a href="#" class="text-reset">{{Auth::user()->email}}</a>
                  </div>
                  <div class="list-inline-item">
                    <!-- Download SVG icon from http://tabler-icons.io/i/cake -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 20h18v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8z" /><path d="M3 14.803c.312 .135 .654 .204 1 .197a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1c.35 .007 .692 -.062 1 -.197" /><path d="M12 4l1.465 1.638a2 2 0 1 1 -3.015 .099l1.55 -1.737z" /></svg>
                    
                  </div>
                </div>
              </div>
              <div class="col-auto ms-auto">
                <div class="btn-list">
                  <a href="#" class="btn btn-icon" aria-label="Button">
                    <!-- Download SVG icon from http://tabler-icons.io/i/dots -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                  </a>
                  <a href="#" class="btn btn-icon" aria-label="Button">
                    <!-- Download SVG icon from http://tabler-icons.io/i/message -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" /><path d="M8 9l8 0" /><path d="M8 13l6 0" /></svg>
                  </a>
                  <a href="#" class="btn btn-primary">
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    Following
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row g-3">
              <div class="col">
                <ul class="timeline">
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-twitter-lt"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">10 hrs ago</div>
                        <h4>+1150 Followers</h4>
                        <p class="text-muted">You’re getting more and more followers, keep it up!</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/briefcase -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">2 hrs ago</div>
                        <h4>+3 New Products were added!</h4>
                        <p class="text-muted">Congratulations!</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/check -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">1 day ago</div>
                        <h4>Database backup completed!</h4>
                        <p class="text-muted">Download the <a href="#">latest backup</a>.</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon bg-facebook-lt"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">1 day ago</div>
                        <h4>+290 Page Likes</h4>
                        <p class="text-muted">This is great, keep it up!</p>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/user-plus -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11h6m-3 -3v6" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">2 days ago</div>
                        <h4>+3 Friend Requests</h4>
                        <div class="avatar-list mt-3">
                          <span class="avatar" style="background-image: url(./static/avatars/000m.jpg)">
                            <span class="badge bg-success"></span></span>
                          <span class="avatar">
                            <span class="badge bg-success"></span>JL</span>
                          <span class="avatar" style="background-image: url(./static/avatars/002m.jpg)">
                            <span class="badge bg-success"></span></span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/photo -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8l.01 0" /><path d="M4 4m0 3a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3z" /><path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">3 days ago</div>
                        <h4>+2 New photos</h4>
                        <div class="mt-3">
                          <div class="row g-2">
                            <div class="col-6">
                              <div class="media media-2x1 rounded">
                                <a class="media-content" style="background-image: url(./static/photos/blue-sofa-with-pillows-in-a-designer-living-room-interior.jpg
)"></a>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="media media-2x1 rounded">
                                <a class="media-content" style="background-image: url(./static/photos/home-office-desk-with-macbook-iphone-calendar-watch-and-organizer.jpg
)"></a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="timeline-event">
                    <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                    </div>
                    <div class="card timeline-event-card">
                      <div class="card-body">
                        <div class="text-muted float-end">2 weeks ago</div>
                        <h4>System updated to v2.02</h4>
                        <p class="text-muted">Check the complete changelog at the <a href="#">activity
                            page</a>.</p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-4">
                <div class="row row-cards">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">

                        <div class="card-title">Основне информаије</div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                <path d="M9 7l6 0"></path>
                                <path d="M9 11l6 0"></path>
                                <path d="M9 15l4 0"></path>
                            </svg>
                            Име и презиме: <strong>{{Auth::user()->ime." ".Auth::user()->prezime}}</strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                <path d="M9 7l6 0"></path>
                                <path d="M9 11l6 0"></path>
                                <path d="M9 15l4 0"></path>
                            </svg>
                            Број индекса: <strong></strong>
                        </div>
                        
                        
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/book -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                          Тренутни програм:<strong></strong>
                        </div>
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/briefcase -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                          Година студија: <strong></strong>
                        </div>
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                            Име једног родитеља: <strong></strong>
                        </div>
                        <div class="mb-2">
                          <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                          @if(1)<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-male text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 14m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                            <path d="M19 5l-5.4 5.4"></path>
                            <path d="M19 5h-5"></path>
                            <path d="M19 5v5"></path>
                         </svg>
                         @else
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gender-female text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"></path>
                            <path d="M12 14v7"></path>
                            <path d="M9 18h6"></path>
                         </svg>
                         @endif
                         Пол: <strong></strong>
                        </div>
                        <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M11 15l1 0" /><path d="M12 15l0 3" /></svg>
                            Датум рођења: <strong></strong>
                        </div>
                        <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-atom text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12v.01"></path>
                                <path d="M19.071 4.929c-1.562 -1.562 -6 .337 -9.9 4.243c-3.905 3.905 -5.804 8.337 -4.242 9.9c1.562 1.561 6 -.338 9.9 -4.244c3.905 -3.905 5.804 -8.337 4.242 -9.9"></path>
                                <path d="M4.929 4.929c-1.562 1.562 .337 6 4.243 9.9c3.905 3.905 8.337 5.804 9.9 4.242c1.561 -1.562 -.338 -6 -4.244 -9.9c-3.905 -3.905 -8.337 -5.804 -9.9 -4.242"></path>
                             </svg>
                            ЈМБГ: <strong></strong>
                          </div>
                          <div class="mb-2">
                            <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-backpack me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 18v-6a6 6 0 0 1 6 -6h2a6 6 0 0 1 6 6v6a3 3 0 0 1 -3 3h-8a3 3 0 0 1 -3 -3z"></path>
                                <path d="M10 6v-1a2 2 0 1 1 4 0v1"></path>
                                <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                                <path d="M11 10h2"></path>
                             </svg>
                            ЈОБ: <strong></strong>
                          </div>
                        <div>
                          <!-- Download SVG icon from http://tabler-icons.io/i/map-pin -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone text-muted me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                         </svg>
                          Телефон: <strong></strong>
                        </div>
                        
                        
                       
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <h2 class="card-title">About Me</h2>
                        <div>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid beatae eaque eius
                            esse fugit, hic id illo itaque modi molestias nemo perferendis quae rerum soluta. Blanditiis
                            laborum minima molestiae molestias nemo nesciunt nisi pariatur quae sapiente ut. Aut consectetur
                            doloremque, error impedit, ipsum labore laboriosam minima non omnis perspiciatis possimus
                            praesentium provident quo recusandae suscipit tempore totam.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endsection
        