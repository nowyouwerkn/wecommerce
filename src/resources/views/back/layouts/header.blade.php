<div class="content-header">
    <div class="content-search">
        <i data-feather="search"></i>
        <input type="search" class="form-control" placeholder="Búsqueda General...">
    </div>
    
    <nav class="nav">
        <div class="dropdown dropdown-notification">
            @php
                $notifications = Nowyouwerkn\WeCommerce\Models\Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->take(5)->get();

                $notifications_all = Nowyouwerkn\WeCommerce\Models\Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->count();
            @endphp
          <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
            <i data-feather="bell"></i>
            <span>{{ $notifications_all }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header">Notificaciones</div>
            @foreach($notifications as $notification)
            <div class="dropdown-item">
              <div class="media">
                <div class="avatar avatar-sm {{-- avatar-online --}}">
                    <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( $notification->user->email ?? 'N/A'))) . '?d=retro&s=150' }}" class="rounded-circle" alt="">
                </div>
                <div class="media-body mg-l-15">
                  <p><strong>{{ $notification->user->name }}</strong> {{ $notification->data }}</p>
                  <span>{{ Carbon\Carbon::parse($notification->created_at)->format('D d g:ia') }}</span>
                </div>
              </div>
            </div>
            @endforeach
        
            <div class="dropdown-footer"><a href="">Leer Todas las Notificaciones</a></div>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->

        <a href="{{ route('configuration') }}" class="nav-link ml-4"><i data-feather="settings"></i></a>
    </nav>

</div>