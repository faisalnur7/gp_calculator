<?php

namespace Database\Seeders;

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
            ['name' => 'Rings',     'description' => 'All types of finger rings including traditional, Turkish, pata and boat styles'],
            ['name' => 'Earrings',  'description' => 'Earrings, jhumkas, chanbali, ear rings and similar ear jewellery'],
            ['name' => 'Necklaces', 'description' => 'Necklaces, chains, ball mala and locket pieces'],
            ['name' => 'Bangles',   'description' => 'Bangles, bala and bracelet pieces'],
            ['name' => 'Sets',      'description' => 'Jewellery sets and combined pieces'],
            ['name' => 'Other',     'description' => 'Miscellaneous jewellery items'],
            ['name' => 'Chain',     'description' => null],
        ];
        foreach ($cats as $cat) {
            JewelleryCategory::create($cat);
        }

        // ── Shops ─────────────────────────────────────────────────────────────
        $shops = [
            ['name' => 'Chawbazar Jewellers',    'code' => 'CHW'],
            ['name' => 'Gifts Chain For Babies',  'code' => 'EFB'],
            ['name' => 'Janani Jewellers',        'code' => 'JAN'],
            ['name' => 'Apon Jewellers',          'code' => 'APO'],
            ['name' => 'Rikson Jewellers',        'code' => 'RIK'],
            ['name' => 'Madina Gold',             'code' => 'MAD'],
            ['name' => 'Swaccha Jewellers',       'code' => 'SWA'],
            ['name' => 'DK Jewellers',            'code' => 'DKJ'],
            ['name' => 'Pinky Jewellers',         'code' => 'PNK'],
            ['name' => 'Biddyakut Jewellers',     'code' => 'BID'],
        ];
        foreach ($shops as $shop) {
            Shop::create($shop);
        }

        // ── Jewellery Items ───────────────────────────────────────────────────
        // Merged from old jewellery_items (name lookup) + documents (purchase data)
        // item_names map: old jewellery_items id => name, category_id
        $itemNames = [
            1  => ['item_name' => 'Ring (KDM) - First',      'category_id' => 1],
            2  => ['item_name' => 'Chains (KDM)',             'category_id' => 7],
            3  => ['item_name' => 'Dhaki Jhumka',             'category_id' => 2],
            4  => ['item_name' => 'Necklace',                 'category_id' => 3],
            5  => ['item_name' => 'Ball Mala',                'category_id' => 3],
            6  => ['item_name' => 'Bala',                     'category_id' => 4],
            7  => ['item_name' => '2nd earring (KDM)',        'category_id' => 2],
            8  => ['item_name' => 'Ring (Turkish)',           'category_id' => 1],
            9  => ['item_name' => 'Ring (Pata)',              'category_id' => 1],
            10 => ['item_name' => 'Sui Suta (KDM)',           'category_id' => 2],
            11 => ['item_name' => 'Chain',                    'category_id' => 7],
            12 => ['item_name' => 'Locket',                   'category_id' => 6],
            13 => ['item_name' => 'Chanbali',                 'category_id' => 2],
            14 => ['item_name' => 'Ring (Traditional Boat)',  'category_id' => 1],
            15 => ['item_name' => 'Ring',                     'category_id' => 1],
            16 => ['item_name' => 'Jhumka',                   'category_id' => 2],
            17 => ['item_name' => 'Ear rings',                'category_id' => 2],
            18 => ['item_name' => 'Prithibi Jhumka',          'category_id' => 2],
            19 => ['item_name' => 'Ring Turkish (Boat)',      'category_id' => 1],
            20 => ['item_name' => 'Bracelet',                 'category_id' => 4],
            21 => ['item_name' => 'Ring pata',                'category_id' => 1],
            22 => ['item_name' => 'Jhapta Earrings',          'category_id' => 2],
        ];

        // Documents data (from DB): shop_id, jewellery_item_id, gold_type, purchase_date, reference, vori, ana, roti, points, unit_price_per_gram
        $documents = [
            ['shop_id' => 1,  'item_id' => 1,  'gold_type' => '21K', 'purchase_date' => '2017-11-07', 'reference' => 'REF-0001',   'vori' => 0, 'ana' => 4,  'roti' => 0, 'points' => 0, 'unit_price_per_gram' => 19845.00],
            ['shop_id' => 2,  'item_id' => 2,  'gold_type' => '22K', 'purchase_date' => '2019-11-29', 'reference' => 'REF-0002',   'vori' => 0, 'ana' => 3,  'roti' => 0, 'points' => 0, 'unit_price_per_gram' => 19845.00],
            ['shop_id' => 3,  'item_id' => 3,  'gold_type' => '22K', 'purchase_date' => '2022-01-30', 'reference' => 'REF-0003',   'vori' => 0, 'ana' => 3,  'roti' => 0, 'points' => 7, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 4,  'item_id' => 4,  'gold_type' => '22K', 'purchase_date' => '2022-08-14', 'reference' => 'REF-0004',   'vori' => 1, 'ana' => 13, 'roti' => 5, 'points' => 7, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 4,  'item_id' => 5,  'gold_type' => '22K', 'purchase_date' => '2023-01-29', 'reference' => 'REF-0005',   'vori' => 0, 'ana' => 9,  'roti' => 0, 'points' => 8, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 5,  'item_id' => 6,  'gold_type' => '21K', 'purchase_date' => '2023-12-23', 'reference' => 'REF-0006',   'vori' => 0, 'ana' => 4,  'roti' => 1, 'points' => 0, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 7,  'gold_type' => '21K', 'purchase_date' => '2022-11-30', 'reference' => 'REF-0007',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'points' => 0, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 8,  'gold_type' => '22K', 'purchase_date' => '2024-07-04', 'reference' => 'REF-0008',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'points' => 3, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 9,  'gold_type' => '22K', 'purchase_date' => '2024-07-04', 'reference' => 'REF-0009',   'vori' => 0, 'ana' => 2,  'roti' => 0, 'points' => 0, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 6,  'item_id' => 10, 'gold_type' => '21K', 'purchase_date' => '2024-11-05', 'reference' => 'REF-0010',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'points' => 8, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 11, 'gold_type' => '22K', 'purchase_date' => '2024-09-06', 'reference' => 'REF-0011',   'vori' => 0, 'ana' => 6,  'roti' => 4, 'points' => 4, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 7,  'item_id' => 12, 'gold_type' => '21K', 'purchase_date' => '2024-06-14', 'reference' => 'REF-0012',   'vori' => 0, 'ana' => 1,  'roti' => 1, 'points' => 2, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 7,  'item_id' => 13, 'gold_type' => '22K', 'purchase_date' => '2024-12-08', 'reference' => 'REF-0013',   'vori' => 0, 'ana' => 3,  'roti' => 4, 'points' => 6, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 14, 'gold_type' => '22K', 'purchase_date' => '2024-08-18', 'reference' => 'REF-0014',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'points' => 3, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 8,  'item_id' => 15, 'gold_type' => '21K', 'purchase_date' => '2024-08-23', 'reference' => 'REF-0015',   'vori' => 0, 'ana' => 2,  'roti' => 4, 'points' => 7, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 3,  'item_id' => 16, 'gold_type' => '22K', 'purchase_date' => '2024-02-09', 'reference' => 'REF-0016',   'vori' => 0, 'ana' => 5,  'roti' => 1, 'points' => 5, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 9,  'item_id' => 17, 'gold_type' => '22K', 'purchase_date' => '2024-09-26', 'reference' => 'REF-0017',   'vori' => 0, 'ana' => 2,  'roti' => 2, 'points' => 2, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 9,  'item_id' => 18, 'gold_type' => '22K', 'purchase_date' => '2024-10-23', 'reference' => 'REF-0018',   'vori' => 0, 'ana' => 4,  'roti' => 1, 'points' => 4, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 9,  'item_id' => 12, 'gold_type' => '22K', 'purchase_date' => '2024-10-25', 'reference' => 'REF-0019',   'vori' => 0, 'ana' => 1,  'roti' => 0, 'points' => 9, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 7,  'item_id' => 19, 'gold_type' => '22K', 'purchase_date' => '2024-04-11', 'reference' => 'REF-0020',   'vori' => 0, 'ana' => 3,  'roti' => 2, 'points' => 5, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 10, 'item_id' => 15, 'gold_type' => '22K', 'purchase_date' => '2025-04-03', 'reference' => 'REF-0021',   'vori' => 0, 'ana' => 2,  'roti' => 2, 'points' => 2, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 9,  'item_id' => 20, 'gold_type' => '22K', 'purchase_date' => '2026-04-19', 'reference' => 'REF-0022',   'vori' => 0, 'ana' => 5,  'roti' => 2, 'points' => 4, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 7,  'item_id' => 21, 'gold_type' => '22K', 'purchase_date' => '2026-03-05', 'reference' => 'REF-0023',   'vori' => 0, 'ana' => 1,  'roti' => 5, 'points' => 3, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 1,  'item_id' => 22, 'gold_type' => '22K', 'purchase_date' => '2017-07-11', 'reference' => 'REF-00024',  'vori' => 0, 'ana' => 9,  'roti' => 0, 'points' => 0, 'unit_price_per_gram' => 20790.00],
            ['shop_id' => 2,  'item_id' => 2,  'gold_type' => '21K', 'purchase_date' => '2019-12-16', 'reference' => 'REF-0002-1', 'vori' => 0, 'ana' => 3,  'roti' => 3, 'points' => 0, 'unit_price_per_gram' => 20790.00],
        ];

        foreach ($documents as $doc) {
            $meta = $itemNames[$doc['item_id']];
            JewelleryItem::create([
                'item_name'           => $meta['item_name'],
                'category_id'         => $meta['category_id'],
                'shop_id'             => $doc['shop_id'],
                'reference'           => $doc['reference'],
                'gold_type'           => $doc['gold_type'],
                'purchase_date'       => $doc['purchase_date'],
                'vori'                => $doc['vori'],
                'ana'                 => $doc['ana'],
                'roti'                => $doc['roti'],
                'points'              => $doc['points'],
                'unit_price_per_gram' => $doc['unit_price_per_gram'],
            ]);
        }
    }
}
