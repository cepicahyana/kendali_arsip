SELECT
    `kendali`.`data_test`.`jenis_pegawai` AS `jenis_pegawai`,
    `kendali`.`data_test`.`kode` AS `kode`,
    `kendali`.`data_test`.`kode_jenis` AS `kode_jenis`,
    `kendali`.`data_test`.`nik` AS `nik`,
    `kendali`.`data_test`.`nama` AS `nama`,
    'id_hub' AS `id_hub`,
    `kendali`.`data_test`.`nip` AS `nip`,
    `kendali`.`data_test`.`hasil` AS `hasil`,
    `kendali`.`data_test`.`file` AS `file`,
    `kendali`.`data_test`.`sts` AS `sts`,
    `kendali`.`data_test`.`konfirm_rs` AS `konfirm_rs`,
    `kendali`.`data_test`.`kode_tempat` AS `kode_tempat`,
    `kendali`.`data_test`.`_ctime` AS `_ctime`,
    `kendali`.`data_test`.`sts_acc` AS `sts_acc`,
    `kendali`.`data_test`.`scan` AS `scan`,
    `kendali`.`data_test`.`istana` AS `istana`,
    `kendali`.`data_test`.`kode_biro` AS `kode_biro`
FROM
    `kendali`.`data_test`
UNION ALL
SELECT NULL AS
    `NULL`,
    `kendali`.`data_test_keluarga`.`kode` AS `kode`,
    `kendali`.`data_test_keluarga`.`kode_jenis` AS `kode_jenis`,
    `kendali`.`data_test_keluarga`.`nik` AS `nik`,
    `kendali`.`data_test_keluarga`.`nama` AS `nama`,
    `kendali`.`data_test_keluarga`.`id_hubungan` AS `id_hubungan`,
    `kendali`.`data_test_keluarga`.`nip_pegawai` AS `nip_pegawai`,
    `kendali`.`data_test_keluarga`.`hasil` AS `hasil`,
    `kendali`.`data_test_keluarga`.`file` AS `file`,
    `kendali`.`data_test_keluarga`.`sts` AS `sts`,
    `kendali`.`data_test_keluarga`.`konfirm_rs` AS `konfirm_rs`,
    `kendali`.`data_test_keluarga`.`kode_tempat` AS `kode_tempat`,
    `kendali`.`data_test_keluarga`.`_ctime` AS `_ctime`,
    `kendali`.`data_test_keluarga`.`sts_acc` AS `sts_acc`,
    `kendali`.`data_test_keluarga`.`scan` AS `scan`,
    `kendali`.`data_test_keluarga`.`istana` AS `istana`,
    `kendali`.`data_test_keluarga`.`kode_biro` AS `kode_biro`
FROM
    `kendali`.`data_test_keluarga`
UNION ALL
SELECT NULL AS
    `NULL`,
    `kendali`.`data_test_external`.`kode` AS `kode`,
    `kendali`.`data_test_external`.`kode_jenis` AS `kode_jenis`,
    `kendali`.`data_test_external`.`nik` AS `nik`,
    `kendali`.`data_test_external`.`nama` AS `nama`,
    'external' AS `external`,
    'nip' AS `nip`,
    `kendali`.`data_test_external`.`hasil` AS `hasil`,
    `kendali`.`data_test_external`.`file` AS `file`,
    `kendali`.`data_test_external`.`sts` AS `sts`,
    `kendali`.`data_test_external`.`konfirm_rs` AS `konfirm_rs`,
    `kendali`.`data_test_external`.`kode_tempat` AS `kode_tempat`,
    `kendali`.`data_test_external`.`_ctime` AS `_ctime`,
    `kendali`.`data_test_external`.`sts_acc` AS `sts_acc`,
    `kendali`.`data_test_external`.`scan` AS `scan`,
    `kendali`.`data_test_external`.`istana` AS `istana`,
    `kendali`.`data_test_external`.`kode_biro` AS `kode_biro`
FROM
    `kendali`.`data_test_external`