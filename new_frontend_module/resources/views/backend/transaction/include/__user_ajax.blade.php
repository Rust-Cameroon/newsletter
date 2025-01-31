
<a class="link" href="{{ $user ? route('admin.user.edit',$user->id) : '#' }}">{{ safe($user->username ?? 'System') }}</a>
