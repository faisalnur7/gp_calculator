<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── User ──────────────────────────────────────────────────────────────
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@abc.com',
            'password' => bcrypt('123123'),
        ]);

        // ── Categories ────────────────────────────────────────────────────────
        $cats = [
            1 => ['name' => 'Rings',     'description' => 'All types of finger rings including traditional, Turkish, pata and boat styles'],
            2 => ['name' => 'Earrings',  'description' => 'Earrings, jhumkas, chanbali, ear rings and similar ear jewellery'],
            3 => ['name' => 'Necklaces', 'description' => 'Necklaces, chains, ball mala and locket pieces'],
            4 => ['name' => 'Bangles',   'description' => 'Bangles, bala and bracelet pieces'],
            5 => ['name' => 'Sets',      'description' => 'Jewellery sets and combined pieces'],
            6 => ['name' => 'Other',     'description' => 'Miscellaneous jewellery items'],
            7 => ['name' => 'Chain',     'description' => null],
        ];

        foreach ($cats as $id => $data) {
            JewelleryCategory::create($data);
        }

        // ── Jewellery Items ───────────────────────────────────────────────────
        $items = [
            ['jewellery_category_id' => 1, 'name' => 'Ring (KDM) - First'],
            ['jewellery_category_id' => 7, 'name' => 'Chains (KDM)'],
            ['jewellery_category_id' => 2, 'name' => 'Dhaki Jhumka'],
            ['jewellery_category_id' => 3, 'name' => 'Necklace'],
            ['jewellery_category_id' => 3, 'name' => 'Ball Mala'],
            ['jewellery_category_id' => 4, 'name' => 'Bala'],
            ['jewellery_category_id' => 2, 'name' => '2nd earring (KDM)'],
            ['jewellery_category_id' => 1, 'name' => 'Ring (Turkish)'],
            ['jewellery_category_id' => 1, 'name' => 'Ring (Pata)'],
            ['jewellery_category_id' => 2, 'name' => 'Sui Suta (KDM)'],
            ['jewellery_category_id' => 7, 'name' => 'Chain'],
            ['jewellery_category_id' => 6, 'name' => 'Locket'],
            ['jewellery_category_id' => 2, 'name' => 'Chanbali'],
            ['jewellery_category_id' => 1, 'name' => 'Ring (Traditional Boat)'],
            ['jewellery_category_id' => 1, 'name' => 'Ring'],
            ['jewellery_category_id' => 2, 'name' => 'Jhumka'],
            ['jewellery_category_id' => 2, 'name' => 'Ear rings'],
            ['jewellery_category_id' => 2, 'name' => 'Prithibi Jhumka'],
            ['jewellery_category_id' => 1, 'name' => 'Ring Turkish (Boat)'],
            ['jewellery_category_id' => 4, 'name' => 'Bracelet'],
            ['jewellery_category_id' => 1, 'name' => 'Ring pata'],
            ['jewellery_category_id' => 2, 'name' => 'Jhapta Earrings'],
        ];

        foreach ($items as $item) {
            JewelleryItem::create($item);
        }

        // ── Shops ─────────────────────────────────────────────────────────────
        $shops = [
            ['name' => 'Chawbazar Jewellers',   'code' => 'CHW'],
            ['name' => 'Gifts Chain For Babies', 'code' => 'EFB'],
            ['name' => 'Janani Jewellers',       'code' => 'JAN'],
            ['name' => 'Apon Jewellers',         'code' => 'APO'],
            ['name' => 'Rikson Jewellers',       'code' => 'RIK'],
            ['name' => 'Madina Gold',            'code' => 'MAD'],
            ['name' => 'Swaccha Jewellers',      'code' => 'SWA'],
            ['name' => 'DK Jewellers',           'code' => 'DKJ'],
            ['name' => 'Pinky Jewellers',        'code' => 'PNK'],
            ['name' => 'Biddyakut Jewellers',    'code' => 'BID'],
        ];

        foreach ($shops as $shop) {
            Shop::create($shop);
        }

        // ── Documents ─────────────────────────────────────────────────────────
        // Note: total_points, total_grams, subtotal are auto-computed by Document model booted()
        $documents = [
            ['shop_id' => 1,  'jewellery_item_id' => 1,  'gold_type' => '21K', 'document_date' => '2017-11-07', 'reference_number' => 'REF-0001',   'vori' => 0, 'ana' => 4,  'roti' => 0, 'point' => 0, 'unit_price_per_gram' => 19845.00, 'status' => 'approved'],
            ['shop_id' => 2,  'jewellery_item_id' => 2,  'gold_type' => '22K', 'document_date' => '2019-11-29', 'reference_number' => 'REF-0002',   'vori' => 0, 'ana' => 3,  'roti' => 0, 'point' => 0, 'unit_price_per_gram' => 19845.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 3,  'gold_type' => '22K', 'document_date' => '2022-01-30', 'reference_number' => 'REF-0003',   'vori' => 0, 'ana' => 3,  'roti' => 0, 'point' => 7, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 4,  'jewellery_item_id' => 4,  'gold_type' => '22K', 'document_date' => '2022-08-14', 'reference_number' => 'REF-0004',   'vori' => 1, 'ana' => 13, 'roti' => 5, 'point' => 7, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 4,  'jewellery_item_id' => 5,  'gold_type' => '22K', 'document_date' => '2023-01-29', 'reference_number' => 'REF-0005',   'vori' => 0, 'ana' => 9,  'roti' => 0, 'point' => 8, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 5,  'jewellery_item_id' => 6,  'gold_type' => '21K', 'document_date' => '2023-12-23', 'reference_number' => 'REF-0006',   'vori' => 0, 'ana' => 4,  'roti' => 1, 'point' => 0, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 7,  'gold_type' => '21K', 'document_date' => '2022-11-30', 'reference_number' => 'REF-0007',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'point' => 0, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 8,  'gold_type' => '22K', 'document_date' => '2024-07-04', 'reference_number' => 'REF-0008',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'point' => 3, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 9,  'gold_type' => '21K', 'document_date' => '2024-07-04', 'reference_number' => 'REF-0009',   'vori' => 0, 'ana' => 2,  'roti' => 0, 'point' => 0, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 6,  'jewellery_item_id' => 10, 'gold_type' => '21K', 'document_date' => '2024-11-05', 'reference_number' => 'REF-0010',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'point' => 8, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 11, 'gold_type' => '22K', 'document_date' => '2024-09-06', 'reference_number' => 'REF-0011',   'vori' => 0, 'ana' => 6,  'roti' => 4, 'point' => 4, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 7,  'jewellery_item_id' => 12, 'gold_type' => '21K', 'document_date' => '2024-06-14', 'reference_number' => 'REF-0012',   'vori' => 0, 'ana' => 1,  'roti' => 1, 'point' => 2, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 7,  'jewellery_item_id' => 13, 'gold_type' => '22K', 'document_date' => '2024-12-08', 'reference_number' => 'REF-0013',   'vori' => 0, 'ana' => 3,  'roti' => 4, 'point' => 6, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 14, 'gold_type' => '22K', 'document_date' => '2024-08-18', 'reference_number' => 'REF-0014',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'point' => 3, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 8,  'jewellery_item_id' => 15, 'gold_type' => '21K', 'document_date' => '2024-08-23', 'reference_number' => 'REF-0015',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'point' => 7, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 3,  'jewellery_item_id' => 16, 'gold_type' => '22K', 'document_date' => '2024-02-09', 'reference_number' => 'REF-0016',   'vori' => 0, 'ana' => 5,  'roti' => 1, 'point' => 5, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 9,  'jewellery_item_id' => 17, 'gold_type' => '22K', 'document_date' => '2024-09-26', 'reference_number' => 'REF-0017',   'vori' => 0, 'ana' => 2,  'roti' => 2, 'point' => 2, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 9,  'jewellery_item_id' => 18, 'gold_type' => '22K', 'document_date' => '2024-10-23', 'reference_number' => 'REF-0018',   'vori' => 0, 'ana' => 4,  'roti' => 1, 'point' => 4, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 9,  'jewellery_item_id' => 12, 'gold_type' => '22K', 'document_date' => '2024-10-25', 'reference_number' => 'REF-0019',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'point' => 9, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 7,  'jewellery_item_id' => 19, 'gold_type' => '22K', 'document_date' => '2024-04-11', 'reference_number' => 'REF-0020',   'vori' => 0, 'ana' => 3,  'roti' => 2, 'point' => 5, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 10, 'jewellery_item_id' => 15, 'gold_type' => '21K', 'document_date' => '2025-04-03', 'reference_number' => 'REF-0021',   'vori' => 0, 'ana' => 2,  'roti' => 2, 'point' => 2, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 9,  'jewellery_item_id' => 20, 'gold_type' => '22K', 'document_date' => '2026-04-19', 'reference_number' => 'REF-0022',   'vori' => 0, 'ana' => 5,  'roti' => 2, 'point' => 4, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 7,  'jewellery_item_id' => 21, 'gold_type' => '22K', 'document_date' => '2026-03-05', 'reference_number' => 'REF-0023',   'vori' => 0, 'ana' => 1,  'roti' => 5, 'point' => 3, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 1,  'jewellery_item_id' => 22, 'gold_type' => '22K', 'document_date' => '2017-07-11', 'reference_number' => 'REF-00024',  'vori' => 0, 'ana' => 9,  'roti' => 0, 'point' => 0, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
            ['shop_id' => 2,  'jewellery_item_id' => 2,  'gold_type' => '21K', 'document_date' => '2019-12-16', 'reference_number' => 'REF-0002-1', 'vori' => 0, 'ana' => 3,  'roti' => 3, 'point' => 0, 'unit_price_per_gram' => 20790.00, 'status' => 'approved'],
        ];

        foreach ($documents as $doc) {
            Document::create($doc);
        }
    }
}
