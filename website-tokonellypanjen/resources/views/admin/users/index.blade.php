@extends('layouts.admin')

@section('title', 'Manajemen Akun Pengguna & Staf')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <div>
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Pengguna Sistem</h2>
        <p class="mt-1 text-sm text-slate-500">Kelola akses untuk Admin, Kasir/Staff, dan Customer.</p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- NEW USER FORM -->
        <div class="xl:col-span-1 border-brand-100">
            <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden sticky top-28">
                <div class="px-6 py-5 border-b border-brand-100 bg-brand-50">
                    <h3 class="font-outfit font-bold text-lg text-brand-900">Tambah Akun Baru</h3>
                </div>
                
                <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-brand-900 mb-1 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-900 mb-1 uppercase tracking-wide">Alamat Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-900 mb-1 uppercase tracking-wide">Kata Sandi (Min 8)</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-900 mb-1 uppercase tracking-wide">Hak Akses</label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none bg-white font-medium">
                            <option value="staff">Staff Toko (Kasir)</option>
                            <option value="admin">Administrator</option>
                            <option value="customer">Customer Publik</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full mt-4 py-3 bg-brand-900 hover:bg-brand-950 text-white rounded-xl font-bold shadow-lg shadow-brand-900/20 transition-all hover:-translate-y-0.5">
                        Daftarkan Pengguna
                    </button>
                </form>
            </div>
        </div>

        <!-- USERS TABLE -->
        <div class="xl:col-span-2">
            <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-brand-100 flex justify-between items-center">
                    <h3 class="font-outfit font-bold text-lg text-brand-900">Daftar Pengguna Saat Ini</h3>
                    <div class="text-sm text-slate-500"><span class="font-bold text-brand-600">{{ $users->count() }}</span> Terdaftar</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-brand-100">
                        <thead class="bg-brand-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Pengguna & Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Akses Peran</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Bergabung</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-50">
                            @foreach($users as $user)
                            <tr class="hover:bg-brand-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold font-outfit text-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-brand-900">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'admin' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'staff' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                            'customer' => 'bg-slate-100 text-slate-700 border-slate-200'
                                        ];
                                        $label = $colors[$user->role] ?? 'bg-slate-100';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm border {{ $label }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-slate-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus akun {{ $user->name }} perpamanen? Data tidak dapat dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus Akun">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-1 rounded">Anda</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
