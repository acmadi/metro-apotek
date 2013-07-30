<?php
include_once '../models/masterdata.php';
include_once '../inc/functions.php';
?>
<table cellspacing="0" width="100%" class="table">
<thead>
<tr class="italic">
    <th width="5%">No.</th>
    <th width="25%">Nama Barang</th>
    <th width="15%">Pabrik</th>
    <th width="10%">Kekuatan</th>
    <th width="10%">Satuan<br/> Kekuatan</th>
    <th width="10%">Golongan</th>
    <th width="10%">Sediaan</th>
    <th width="5%">Adm R</th>
    <th width="4%">#</th>
</tr>
</thead>
<tbody>
    <?php
    $limit = 10;
    $page  = $_GET['page'];
    if ($_GET['page'] === '') {
        $page = 1;
        $offset = 0;
    } else {
        $offset = ($page-1)*$limit;
    }
    
    $param = array(
        'id' => $_GET['id_barang'],
        'limit' => $limit,
        'start' => $offset,
        'search' => $_GET['search']
    );
    $master_barang = load_data_barang($param);
    $list_data = $master_barang['data'];
    $total_data= $master_barang['total'];
    foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->kekuatan.'#'.$data->satuan_kekuatan.'#'.$data->id_sediaan.'#'. // 0 - 4
                $data->id_golongan.'#'.$data->adm_r.'#'.$data->id_pabrik.'#'.$data->pabrik.'#'. // 5 - 8
                $data->id_supplier.'#'.$data->supplier.'#'.$data->rak.'#'.
                
                $data->indikasi.'#'.$data->dosis.'#'.$data->kandungan.'#'.$data->perhatian.'#'.$data->kontra_indikasi.'#'.
                $data->efek_samping;
        ?>
    <tr class="<?= ($key%2==0)?'italic':'dark bold' ?>">
        <td align="center"><?= (++$key+$offset) ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->pabrik ?></td>
        <td align="center"><?= $data->kekuatan ?></td>
        <td align="center"><?= $data->satuan ?></td>
        <td><?= $data->golongan ?></td>
        <td><?= $data->sediaan ?></td>
        <td><?= $data->adm_r ?></td>
        <td class='aksi' align='center'>
            <a class='edition' onclick="edit_barang('<?= $str ?>');" title="Klik untuk edit barang">&nbsp;</a>
            <a class='deletion' onclick="delete_barang('<?= $data->id ?>','<?= $page ?>');" title="Klik untuk hapus barang">&nbsp;</a>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>

<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>