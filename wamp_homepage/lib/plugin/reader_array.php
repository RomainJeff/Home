<?php

class Reader_Array
{
    public $months = [
        'Jan'   => '01',
        'Feb'   => '02',
        'Fev'   => '02',
        'Mar'   => '03',
        'Apr'   => '04',
        'Avr'   => '04',
        'Mai'   => '05',
        'Jun'   => '06',
        'Jul'   => '07',
        'Jui'   => '07',
        'Aug'   => '08',
        'Aou'   => '08',
        'Sep'   => '09',
        'Oct'   => '10',
        'Nov'   => '11',
        'Dec'   => '12'
    ];

    /**
     * Tri un tableau par date
     * @param   string|int|object   a
     * @param   string|int|object   b
     */
    public function date ($a, $b) 
    {
        $a = str_replace(',', '', $a->pubDate);
        $a = explode(' ', $a);
        //var_dump($a); die();
        $a = mktime(0, 0, 0, $this->months[$a[2]], $a[1], $a[3]);

        $b = str_replace(',', '', $b->pubDate);
        $b = explode(' ', $b);
        $b = mktime(0, 0, 0, $this->months[$b[2]], $b[1], $b[3]);

        return ($a > $b) ? -1 : 1;
    }

    public function dateInverse ($a, $b) 
    {
        $a = str_replace(',', '', $a->pubDate);
        $a = explode(' ', $a);
        //var_dump($a); die();
        $a = mktime(0, 0, 0, $this->months[$a[2]], $a[1], $a[3]);

        $b = str_replace(',', '', $b->pubDate);
        $b = explode(' ', $b);
        $b = mktime(0, 0, 0, $this->months[$b[2]], $b[1], $b[3]);

        return ($a > $b) ? 1 : -1;
    }

    public function transformDate ($date) {
        $a = str_replace(',', '', $date);
        $a = explode(' ', $a);

        return [
            'd' => $a[1],
            'm' => $this->months[$a[2]],
            'y' => $a[3]
        ];
    }
}