# Activity Diagram: Pemesanan Kendaraan

```mermaid
flowchart TD
    Start([Mulai])
    Login([Login ke aplikasi])
    PilihMenu([Pilih menu Booking])
    BuatBooking([Isi form booking])
    [Admin/User] --> BuatBooking
    SubmitDraft([Submit booking (status draft > pending)])
    BuatBooking --> SubmitDraft
    Approval1([Approval Level 1])
    Approval2([Approval Level 2])
    SubmitDraft --> Approval1
    Approval1 -- Ditolak --> Ditolak([Status: rejected])
    Approval1 -- Disetujui --> Approval2
    Approval2 -- Ditolak --> Ditolak
    Approval2 -- Disetujui --> Approved([Status: approved])
    Approved --> OnUse([Admin set status onuse])
    OnUse --> Finish([Admin set status finish])
    Ditolak --> Selesai([Selesai])
    Finish --> Selesai

    classDef admin fill:#f9f,stroke:#333,stroke-width:2px;
    class OnUse,Finish admin;
```

---

## Penjelasan
- User atau admin login, lalu mengisi form booking.
- Booking yang dibuat berstatus draft, lalu bisa di-submit menjadi pending.
- Proses approval dilakukan berurutan oleh approver level 1 lalu level 2.
- Jika salah satu approver menolak, status booking menjadi rejected.
- Jika kedua approver menyetujui, status booking menjadi approved.
- Hanya admin yang dapat mengubah status menjadi onuse (kendaraan dipakai) dan finish (selesai digunakan). 