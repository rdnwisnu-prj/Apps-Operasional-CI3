<?php
$field_prefix = isset($form_mode) && $form_mode !== '' ? $form_mode : 'form';
$current_role_id = isset($current_role_id) ? (int) $current_role_id : (int) $this->session->userdata('role_id');
$proses_labels = $proses_labels ?? [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$allowed_proses_options = $allowed_proses_options ?? $proses_labels;
?>
<?php if ($current_role_id === 8): ?>
<label class="form-label" for="<?= $field_prefix; ?>_proses_display">Proses</label>
<input type="text" class="form-control" id="<?= $field_prefix; ?>_proses_display" value="<?= html_escape($proses_labels['2']); ?>" readonly>
<input type="hidden" id="<?= $field_prefix; ?>_proses" name="proses" value="2">
<?php else: ?>
<label class="form-label" for="<?= $field_prefix; ?>_proses">Proses <span class="text-danger">*</span></label>
<select class="form-select" id="<?= $field_prefix; ?>_proses" name="proses" required>
    <option value="">-- Pilih Proses --</option>
    <?php foreach ($allowed_proses_options as $value => $label): ?>
    <option value="<?= html_escape($value); ?>"><?= html_escape($label); ?></option>
    <?php endforeach; ?>
</select>
<?php endif; ?>
