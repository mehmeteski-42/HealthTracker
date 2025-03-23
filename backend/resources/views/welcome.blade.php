<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- FRONTEND EKLENİNCE KALDIRILACAK-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('navbar')

    <div class="container text-center mt-5">
        <h1 class="mb-4">Welcome to HealthTracker</h1>
        <p class="lead">Your health, our priority.</p>

        @if(Auth::check())
            <p class="mt-3">Hoş geldin, <strong>{{ Auth::user()->name }}</strong>!</p>
            <form method="POST" action="{{ route('logout') }}" class="mb-4">
                @csrf
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>

            <!-- Randevular -->
            @if($appointments->isNotEmpty())
                <h2 class="mt-5">En Yakın Randevunuz</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Doktor Adı</th>
                                <th>Randevu Tarihi</th>
                                <th>Randevu Saati</th>
                                <th>Bölüm</th>
                                <th>Lokasyon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->department }}</td>
                                    <td>{{ $appointment->location }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Henüz bir randevunuz bulunmamaktadır.</p>
            @endif

            <!-- İlaçlar -->
            <h2 class="mt-5">En Yakın İlacınız</h2>
            @if($medications->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>İlaç Adı</th>
                                <th>Alınma Zamanı</th>
                                <th>Detaylı Bilgi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medications as $medication)
                                <tr>
                                    <td>{{ $medication->name }}</td>
                                    <td>{{ $medication->time }}</td>
                                    <td>{{ $medication->additional_notes }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Düzenle</button>
                                        <button class="btn btn-danger btn-sm">Sil</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Henüz bir ilaç eklenmemiştir.</p>
            @endif
        @else
            <div class="mt-5">
                <a href="{{ route('loginAccount') }}" class="btn btn-primary btn-lg">Login</a>
                <a href="{{ route('registerAccount') }}" class="btn btn-secondary btn-lg">Register</a>
            </div>
        @endif
    </div>

    <!-- FRONTEND EKLENINCE KALDIRILACAK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>