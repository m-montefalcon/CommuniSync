@include('partials.__header')
@include('components.nav')
    <h1>QR CODE</h1>    
    <table>
        <thead>
            <tr>
            <th>QR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($qrcodes as $code)
            <tr>
            {!! $code->qr_code !!}            
            </tr>
            @endforeach
        </tbody>
    </table>
@include('partials.__footer')