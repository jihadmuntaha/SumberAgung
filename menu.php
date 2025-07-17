<?php
include 'backend/koneksi.php';

function tampilkanMenu($kategori) {
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM menu WHERE kategori='$kategori'");
    echo '<div class="d-flex flex-wrap justify-content-center">';
    while($d = mysqli_fetch_assoc($q)) {
        echo '<div class="px-3 py-sm-3 text-center" style="width: 220px;">';
        echo '<img src="admin/upload/' . $d['gambar'] . '" class="img-fluid rounded" style="height:200px;object-fit:cover">';
        echo '<h4 class="text-yellow pt-3 text-capitalize">' . htmlspecialchars($d['nama']) . '</h4>';

        $harga = $d['harga'];
        $diskon = $d['diskon']; // Pastikan ada kolom 'diskon' di tabel menu

        if ($diskon > 0) {
            $hargaDiskon = $harga - ($harga * $diskon / 100);
            echo '<h5 class="text-muted mb-0"><del>Rp ' . number_format($harga, 0, ',', '.') . '</del></h5>';
            echo '<h5 class="text-warning">Rp ' . number_format($hargaDiskon, 0, ',', '.') . 
                 ' <span class="badge badge-success ml-1">' . $diskon . '%</span></h5>';
        } else {
            echo '<h5 class="text-white">Rp ' . number_format($harga, 0, ',', '.') . '</h5>';
        }

        echo '</div>';
    }
    echo '</div>';
}
?>

<?php include 'partials/header.php'; ?>

<style>
    .text-yellow {
        color: #ffc107;
    }

    .text-warning {
        color: #ffdd57 !important;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
        padding: 4px 6px;
        font-size: 0.8rem;
        border-radius: 4px;
    }

    del {
        color: #888;
        font-size: 0.85rem;
    }

    .blackish {
        background-color: #111;
    }
</style>

<main>
    <section class="text-center black blackish">
        <div class="py-5 blackish">
            <div class="container blackish">
                <h2 class="text-yellow text-capitalize mb-4">Explore Our Menu</h2>

                <ul class="middle nav-fill nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="text-yellow active px-md-4">
                        <a data-toggle="tab" class="nav-link tab-link text-yellow px-md-4 active" id="#mainmenu"
                            href="#mainmenu" role="tab">Minuman</a>
                    </li>
                    <li class="text-white px-md-4">
                        <a data-toggle="tab" class="nav-link tab-link text-yellow px-md-4" id="#desserts"
                            href="#desserts" role="tab">Makanan</a>
                    </li>
                    <li>
                        <a data-toggle="tab" class="nav-link tab-link text-yellow px-md-4" id="#Jajanan"
                            href="#Jajanan" role="tab">Jajanan</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content py-4">
                <div class="tab-pane fade show active" id="mainmenu">
                    <?php tampilkanMenu('minuman'); ?>
                </div>
                <div class="tab-pane fade" id="desserts">
                    <?php tampilkanMenu('makanan'); ?>
                </div>
                <div class="tab-pane fade" id="Jajanan">
                    <?php tampilkanMenu('jajanan'); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
