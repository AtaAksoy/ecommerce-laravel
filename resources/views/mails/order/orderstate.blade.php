Merhaba {{ $customer->name }}!
Bu bir otomatik maildir. <a href="{{ route('ordersuccess', $order->code) }}">#{{ $order->code }}</a> numaralı siparişinizin durumunu
@switch($order->state)
    @case(1)
        Yeni Sipariş
        @break
    @case(2)
        Hazırlanıyor
        @break
    @case(3)
        Kargoya Verildi
        @break
    @case(4)
        Teslim Edildi
        @break
    @case(5)
        İptal Edildi
        @break
    @default

@endswitch
olarak değiştirilmiştir, iyi günler dileriz.
