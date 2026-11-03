<?php

namespace Tests\Unit;

use App\Models\Award;
use Tests\TestCase;

class AwardModelTest extends TestCase
{
    public function test_award_fillable_attributes(): void
    {
        $award = new Award([
            'title' => 'Zona Integritas WBBM',
            'badge' => 'Penghargaan Kemendikdasmen',
            'description' => 'Penghargaan Zona Integritas Wilayah Birokrasi Bersih dan Melayani.',
            'image' => 'awards/wbbm.jpg',
            'order' => 1,
        ]);

        $this->assertEquals('Zona Integritas WBBM', $award->title);
        $this->assertEquals('Penghargaan Kemendikdasmen', $award->badge);
        $this->assertEquals('Penghargaan Zona Integritas Wilayah Birokrasi Bersih dan Melayani.', $award->description);
        $this->assertEquals('awards/wbbm.jpg', $award->image);
        $this->assertEquals(1, $award->order);
        $this->assertIsInt($award->order);
    }
}
