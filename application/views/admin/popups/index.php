<h1 class="admin-page-title">Kelola Popup Promo</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Popup</h3>
    <a href="<?= base_url('admin/popups/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Gambar</th><th>Judul</th><th>Tipe</th><th>Frekuensi</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($popups)): ?><tr><td colspan="6" style="text-align:center;color:var(--gray-400)">Belum ada popup</td></tr>
    <?php else: foreach ($popups as $p):
      // Resolve image: popup's own image → linked post's image → none
      $img = $p->image ? $p->image : (!empty($p->post_image) ? $p->post_image : '');
      // Resolve title
      $title = $p->title ? $p->title : (!empty($p->post_title) ? $p->post_title : '-');
      // Type badges
      $type_badges = [
        'berita' => ['bg'=>'#DBEAFE','color'=>'#1E40AF','label'=>'📰 Berita'],
        'event'  => ['bg'=>'#FEF3C7','color'=>'#92400E','label'=>'📅 Event'],
        'promo'  => ['bg'=>'#D1FAE5','color'=>'#065F46','label'=>'🏷️ Promo'],
        'tips'   => ['bg'=>'#EDE9FE','color'=>'#5B21B6','label'=>'💡 Tips'],
        'info'   => ['bg'=>'#E0F2FE','color'=>'#075985','label'=>'ℹ️ Info'],
        'custom' => ['bg'=>'#F3F4F6','color'=>'#374151','label'=>'✏️ Custom'],
      ];
      $type = isset($p->popup_type) ? $p->popup_type : 'custom';
      $badge = isset($type_badges[$type]) ? $type_badges[$type] : $type_badges['custom'];
    ?>
    <tr>
      <td><?= $img ? '<img src="' . base_url('assets/uploads/' . $img) . '" style="width:60px;height:40px;object-fit:cover;border-radius:4px">' : '<span style="color:var(--gray-400)">-</span>'; ?></td>
      <td><strong><?= $title; ?></strong><?php if (!empty($p->post_title) && $p->title): ?><br><small style="color:var(--gray-400)">dari: <?= $p->post_title; ?></small><?php endif; ?></td>
      <td><span style="display:inline-block;padding:.2rem .6rem;border-radius:var(--radius-full);font-size:.7rem;font-weight:600;background:<?= $badge['bg']; ?>;color:<?= $badge['color']; ?>"><?= $badge['label']; ?></span></td>
      <td><span class="badge badge-warning"><?= $p->frequency; ?></span></td>
      <td><?= $p->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/popups/edit/' . $p->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/popups/delete/' . $p->id); ?>', 'Popup')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
  </div>
</div>