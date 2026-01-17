<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Hardware product titles by category
     */
    private array $productTitles = [
        'hammers' => [
            'Claw Hammer 16oz',
            'Ball Peen Hammer 12oz',
            'Sledge Hammer 8lb',
            'Rubber Mallet',
            'Dead Blow Hammer',
            'Framing Hammer 22oz',
            'Tack Hammer',
            'Club Hammer 4lb',
            'Cross Peen Hammer',
            'Soft Face Hammer',
            'Brick Hammer',
            'Drywall Hammer',
            'Welding Hammer',
            'Chipping Hammer',
            'Planishing Hammer',
            'Riveting Hammer',
            'Trim Hammer',
            'Engineering Hammer',
            'Blacksmith Hammer',
            'Mini Sledge Hammer',
        ],
        'wrenches' => [
            'Adjustable Wrench 10"',
            'Combination Wrench Set',
            'Socket Wrench 3/8"',
            'Pipe Wrench 14"',
            'Torque Wrench 25-250 ft-lb',
            'Allen Key Set Metric',
            'Crescent Wrench 8"',
            'Box End Wrench Set',
            'Open End Wrench Set',
            'Ratcheting Wrench Set',
            'Basin Wrench',
            'Strap Wrench',
            'Crowfoot Wrench Set',
            'Flare Nut Wrench Set',
            'Stubby Wrench Set',
            'Impact Socket Set',
            'Spark Plug Socket',
            'Oil Filter Wrench',
            'Spanner Wrench',
            'Flex Head Wrench Set',
        ],
        'screws' => [
            'Wood Screws #8 x 2" (100pk)',
            'Drywall Screws 1-5/8" (200pk)',
            'Machine Screws M4 (50pk)',
            'Sheet Metal Screws #10 (75pk)',
            'Deck Screws 3" (100pk)',
            'Lag Screws 1/4" x 3" (25pk)',
            'Self-Tapping Screws (100pk)',
            'Concrete Screws 3/16" (50pk)',
            'Cabinet Screws (100pk)',
            'Pocket Hole Screws (250pk)',
            'Trim Head Screws (200pk)',
            'Structural Screws 4" (50pk)',
            'Stainless Steel Screws (100pk)',
            'Brass Wood Screws (50pk)',
            'Chipboard Screws (200pk)',
            'Confirmat Screws (100pk)',
            'Dowel Screws (50pk)',
            'Hanger Bolts (25pk)',
            'Set Screws Assortment',
            'Security Screws Kit',
        ],
        'drills' => [
            'Cordless Drill 20V',
            'Hammer Drill 1/2"',
            'Impact Driver Kit',
            'Drill Bit Set HSS',
            'Masonry Drill Bits',
            'Spade Bit Set',
            'Forstner Bit Set',
            'Hole Saw Kit',
            'Step Drill Bit Set',
            'Countersink Bit Set',
            'Brad Point Bits',
            'Auger Bit Set',
            'Tile Drill Bits',
            'Glass Drill Bits',
            'Cobalt Drill Bit Set',
            'Installer Bit Kit',
            'Right Angle Drill',
            'Magnetic Drill Press',
            'Drill Guide Jig',
            'Depth Stop Collar Set',
        ],
        'nails' => [
            'Common Nails 3" (5lb)',
            'Finish Nails 2" (1lb)',
            'Brad Nails 18ga (1000pk)',
            'Roofing Nails 1.5" (5lb)',
            'Framing Nails 3.5" (2000pk)',
            'Concrete Nails 2" (1lb)',
            'Masonry Nails (100pk)',
            'Duplex Nails 16d (1lb)',
            'Ring Shank Nails (5lb)',
            'Spiral Nails 2.5" (1lb)',
            'Cut Nails 2" (1lb)',
            'Hardwood Flooring Nails',
            'Siding Nails 2.5" (5lb)',
            'Joist Hanger Nails (1lb)',
            'Galvanized Nails 3" (5lb)',
            'Stainless Nails 2" (1lb)',
            'Copper Nails 1" (100pk)',
            'Upholstery Nails (200pk)',
            'Wire Nails Assortment',
            'Headless Pins 23ga (2000pk)',
        ],
    ];

    /**
     * Product descriptions by category
     */
    private array $descriptions = [
        'hammers' => [
            'Professional-grade hammer with fiberglass handle for reduced vibration.',
            'Heavy-duty construction with forged steel head and comfortable grip.',
            'Precision balanced for optimal striking power and control.',
            'Ergonomic design reduces fatigue during extended use.',
            'Premium quality tool built to withstand demanding job site conditions.',
        ],
        'wrenches' => [
            'Chrome vanadium steel construction for maximum durability.',
            'Precision machined jaws ensure secure grip on fasteners.',
            'Mirror chrome finish resists corrosion and cleans easily.',
            'Meets or exceeds ANSI specifications for torque and durability.',
            'Professional quality tool for automotive and industrial applications.',
        ],
        'screws' => [
            'Premium fasteners with corrosion-resistant coating.',
            'Sharp threads for easy driving and superior holding power.',
            'Heat-treated for strength and durability.',
            'Compatible with power drivers and hand tools.',
            'Ideal for professional and DIY applications.',
        ],
        'drills' => [
            'High-performance motor delivers maximum power and speed.',
            'Precision engineered for accurate drilling in multiple materials.',
            'Professional-grade construction for long-lasting durability.',
            'Optimized geometry for fast chip removal and cool operation.',
            'Suitable for wood, metal, plastic, and composite materials.',
        ],
        'nails' => [
            'Hot-dipped galvanized for superior corrosion resistance.',
            'Diamond point ensures easy starting and straight driving.',
            'Precision manufactured for consistent quality.',
            'Compatible with pneumatic nailers and hand driving.',
            'Meets building code requirements for structural applications.',
        ],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create categories
        $categoryNames = ['hammers', 'wrenches', 'screws', 'drills', 'nails'];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[$name] = Category::create(['category' => ucfirst($name)]);
        }

        // Create brands
        $brandNames = ['Acme', 'Brown', 'Charlie', 'Delta', 'Edman'];
        $brands = [];
        foreach ($brandNames as $name) {
            $brands[$name] = Brand::create(['brand' => $name]);
        }

        // Create 100 products: 20 per category, 20 per brand
        // We'll distribute brands evenly across categories
        $skuCounter = 1;
        $brandIndex = 0;

        foreach ($categoryNames as $categoryName) {
            $category = $categories[$categoryName];
            $titles = $this->productTitles[$categoryName];
            $descriptions = $this->descriptions[$categoryName];

            for ($i = 0; $i < 20; $i++) {
                // Cycle through brands (each brand gets 4 products per category = 20 total)
                $brand = $brands[$brandNames[$brandIndex % 5]];

                Product::create([
                    'title' => $titles[$i],
                    'description' => $descriptions[$i % 5],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'price' => rand(299, 29999) / 100, // 2.99 to 299.99
                    'stock' => rand(0, 500),
                    'sku' => sprintf('SKU-%05d', $skuCounter),
                    'weight' => round(rand(10, 5000) / 100, 2), // 0.10 to 50.00 lbs
                ]);

                $skuCounter++;
                $brandIndex++;
            }
        }
    }
}
