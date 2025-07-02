<aside id="sidebar"
  class="fixed top-0 left-0 z-40 w-64 h-screen bg-primary-600 shadow-2xl transition-transform -translate-x-full lg:translate-x-0">
  <div class="h-full  overflow-y-auto">
    <h2 class="text-2xl font-bold mb-6 text-white text-center px-4 py-3">Cicik</h2>
    <ul class="space-y-2 px-4 py-6">
      <livewire:side-item href="/dashboard" title="Dashboard" icon="fa-solid fa-gauge-high" />
      <livewire:side-item href="/layanan" title="Layanan" icon="fa-solid fa-hand-holding-heart" />
      <livewire:side-item href="/pasien" title="Pasien" icon="fa-solid fa-address-book" />
      <livewire:side-item href="/transaksi" title="Transaksi" icon="fa-solid fa-money-bill-transfer" />
    </ul>
  </div>
</aside>