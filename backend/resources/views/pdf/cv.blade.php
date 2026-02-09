<!DOCTYPE html>
<html lang="{{ $language === 'id' ? 'id' : 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->nama }}</title>
    <style>
        @page {
            margin: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            color: #333;
        }

        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 40px;
            display: flex;
            align-items: center;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
            display: block;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            background: #eee;
            margin-right: 40px;
            position: absolute;
            right: 0;
        }

        .profile-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .contact-info {
            font-size: 14px;
            line-height: 1.8;
        }

        .main-content {
            padding: 40px;
            background-color: #fff;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            color: #333;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .education-header, .experience-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 5px;
            width: 100%;
            position: relative;
        }

        .left {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            padding-right: 100px;
            max-width: 70%;
        }

        .right {
            color: #666;
            font-size: 14px;
            position: absolute;
            right: 0;
            text-align: right;
            width: auto;
            white-space: nowrap;
        }

        .degree-info {
            font-style: italic;
            color: #666;
            margin-bottom: 5px;
        }

        .description {
            margin-top: 10px;
            color: #333;
            font-size: 16px;
            text-align: justify;
        }

        .gpa {
            margin-top: 5px;
            color: #666;
        }

        .experience-item, .education-item {
            margin-bottom: 25px;
        }

        ul {
            margin: 5px 0 5px 20px;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .skill-item {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .skill-level {
            float: right;
            color: #666;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .header {
                background-color: #2c3e50 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($user->foto)
                <img src="{{ public_path('storage/' . $user->foto) }}" alt="Foto Profil" class="profile-photo">
            @endif
            <div>
                <div class="profile-name">{{ $user->nama }}</div>
                <div class="contact-info">
                    {{ $user->email }}<br>
                    @if($user->alamat)
                        {{ $user->alamat }}
                    @endif
                </div>
            </div>
        </div>

        <div class="main-content">
            @if($cv && $cv->isi_cv)
            <div class="section">
                <div class="section-title">{{ $translations['introduction'] }}</div>
                <div class="description">
                    {!! nl2br(e($cv->isi_cv)) !!}
                </div>
            </div>
            @endif

            @if($education->count() > 0)
            <div class="section">
                <div class="section-title">{{ $translations['education'] }}</div>
                @foreach($education as $edu)
                <div class="education-item">
                    <div class="education-header">
                        <strong class="left">{{ $edu->institusi }}</strong>
                        <span class="right">
                            {{ $edu->tanggal_mulai->format('M Y') }} - 
                            {{ $edu->tanggal_akhir ? $edu->tanggal_akhir->format('M Y') : $translations['present'] }}
                        </span>
                    </div>
                    <div class="degree-info">{{ $edu->jenjang }} {{ $edu->jurusan }}</div>
                    @if($edu->ipk)
                        <div class="gpa">
                            {{ $translations['gpa'] }}: {{ $edu->ipk }} / 4.00
                        </div>
                    @endif
                    @if($edu->deskripsi)
                        <div class="description">{{ $edu->deskripsi }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($experience->count() > 0)
            <div class="section">
                <div class="section-title">{{ $translations['experience'] }}</div>
                @foreach($experience as $exp)
                <div class="experience-item">
                    <div class="experience-header">
                        <strong class="left">{{ $exp->institusi }}</strong>
                        <span class="right">
                            {{ $exp->tanggal_mulai->format('M Y') }} - 
                            {{ $exp->tanggal_akhir ? $exp->tanggal_akhir->format('M Y') : $translations['present'] }}
                        </span>
                    </div>
                    <div class="degree-info">{{ $exp->posisi }}</div>
                    @if($exp->deskripsi)
                        <div class="description">
                            <ul>
                                @foreach(explode("\n", $exp->deskripsi) as $point)
                                    @if(trim($point))
                                        <li>{{ trim($point) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($skills->count() > 0)
            <div class="section">
                <div class="section-title">{{ $translations['skills'] }}</div>
                <div class="skills-grid">
                    @foreach($skills as $skill)
                        <div class="skill-item">
                            {{ $skill->nama_skill }}
                            <span class="skill-level">{{ $skill->level }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html> 