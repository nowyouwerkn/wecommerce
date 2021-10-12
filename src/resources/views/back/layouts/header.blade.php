<div class="content-header">
    <form class="content-search" role="search" action="{{ route('back.search.query') }}" style="width: 300px;">
        <button type="submit" class="btn btn-link p-0"><i data-feather="search"></i></button>
        <input type="search" name="query" class="form-control" placeholder="Buscar por SKU, Nombre o Etiquetas...">
    </form>
    
    <nav class="nav">
        <div class="dropdown dropdown-notification ml-3">
            @php
                $notifications = Nowyouwerkn\WeCommerce\Models\Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->take(5)->get();

                $notifications_all = Nowyouwerkn\WeCommerce\Models\Notification::where('read_at', NULL)->orderBy('created_at', 'desc')->count();
            @endphp
          <a href="javascript:void(0)" class="dropdown-link new-indicator" data-toggle="dropdown">
            <i data-feather="bell"></i>
            <span>{{ $notifications_all }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header d-flex align-items-center justify-content-between">
                Notificaciones

                <div>
                    <a href="{{ route('notifications.mark.read') }}" data-placement="bottom" data-toggle="tooltip" data-original-title="Marcar todas como leídas" ><i class="fas fa-inbox"></i></a>
                </div>
            </div>

            @if($notifications->count() == 0)
                <div class="dropdown-item text-center">
                    <img src="{{ asset('assets/img/done.svg') }}" alt="Listo" width="60%" class="ml-auto mr-auto mb-4 mt-4">
                    <p><strong>Estás al día con tus notificaciones.</strong></p>
                </div>
            @else
                @foreach($notifications as $notification)
                <div class="dropdown-item">
                  <div class="media">
                    @if(!empty($notification->user))
                    <div class="avatar avatar-sm {{-- avatar-online --}}">
                        <img src="{{ 'https://www.gravatar.com/avatar/' . md5(strtolower(trim( $notification->user->email ?? 'N/A'))) . '?d=retro&s=150' }}" class="rounded-circle" alt="">
                    </div>
                    @endif
                    <div class="media-body mg-l-15">
                      <p><strong>{{ $notification->user->name ?? ''}}</strong> {{ $notification->data }}</p>
                      <span>{{ Carbon\Carbon::parse($notification->created_at)->format('D d g:ia') }}</span>
                    </div>
                  </div>
                </div>
                @endforeach
            @endif
        
            <div class="dropdown-footer"><a href="{{ route('notifications.all') }}">Ver Todas las Notificaciones</a></div>
          </div>
        </div>

        <a href="{{ route('configuration') }}" class="nav-link ml-4"><i data-feather="settings"></i></a>

        <a href="https://github.com/nowyouwerkn/wecommerce/blob/main/CHANGELOG.md" target="_blank" class="badge badge-info ml-3" style="line-height: 14px;">v. 1.2.1</a>
    </nav>
</div>