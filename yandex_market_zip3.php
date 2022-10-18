<?php
shell_exec('cd root/docker/volumes/www/yourfish.ru/cache && rm -f yandex*');
ini_set('zlib.output_compression', 'Off');

chdir(__DIR__);

class YandexMarket
{
    static $cache_time = 86400;
    static $cache_category_time = 86400;
    private static $has_categories_sales = array();
    private static $has_products_specification = array();
    private static $product_info_hrefs = array();
    private static $replace_query = array();
    private static $replace_query_ind = 0;
    private static $max_replace_rows = 5000;
    private static $promo_products = array();

    /**
     *Рендер шапки прайс-листа
     */
    public static function showHeader()
    {
        date_default_timezone_set("Europe/Minsk");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?> 
		<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">
		<yml_catalog date=\"" . date("Y-m-d H:i:s") . "\">
			<shop>
				<name>Рыболовный магазин</name>
				<company>Рыболовный интернет магазин Hydra Fishing</company>
				<url>https://yourfish.ru/</url>
				<currencies>
					<currency id=\"RUB\" rate=\"1\"/>
				</currencies>";
    }

    /**
     * Получаем список дочерних категорий
     * @param int $parent_cat_id - ID родительской категории
     * @return array - массив id категорий
     * @throws DB_exception
     */
    public function getSubcatIds($parent_cat_id)
    {
        $query = "SELECT c.categories_id FROM " . TABLE_CATEGORIES . "  WHERE c.parent_id=" . $parent_cat_id;
        $sub_ids_query = tep_db_query($query);
        $sub_ids = array();
        while ($sub_id = tep_db_fetch_array($sub_ids_query)) {
            $sub_ids[] = $sub_id;
        }
        return $sub_ids;
    }

    /**
     * Рекурсивный поиск подкатегорий
     * @param int $cat_id - ID родительской категории с которой начинаем поиск
     * @return array - массив ID категорий
     * @throws DB_exception
     */
    public function recursiveCatList($cat_id)
    {
        $subcat_ids = $this->getSubcatIds($cat_id);
        $ids = array();
        if (!empty($subcat_ids)) {
            foreach ($subcat_ids as $subcat_id) {
                $get_subcat_ids = $this->recursiveCatList($subcat_id);
                if (!empty($get_subcat_ids)) {
                    $ids = array_merge($ids, $get_subcat_ids);
                    if ($get_subcat_ids[0] != $subcat_id) {
                        $ids[] = $subcat_id;
                    }
                }
            }
        } else {
            return array($cat_id);
        }
        return $ids;
    }

    /**
     * Рендер категорий для прайс листа
     * @param $languages_id - язык сайта
     * @param $exclude_cat - категорий для исклюючения
     */
    public static function showCategories($languages_id, $exclude_cat = null, $include_cat = null)
    {
        if (!read_cache($categories_string, 'categories.cache', self::$cache_category_time)) {
            $categories_query = self::getCategoriesQuery($languages_id, $exclude_cat, $include_cat);
            $categories_string = "<categories>";
            while ($categories = tep_db_fetch_array($categories_query)) {
                $parent = '';
                if ($categories['parent_id'] > 0) {
                    $parent = 'parentId="' . $categories['parent_id'] . '"';
                }
                if (!empty($categories['categories_yandex_name'])) {
                    $cat_name = $categories['categories_yandex_name'];
                } else {
                    $cat_name = $categories['categories_name'];
                }
                $categories_string .= '
                <category id="' . $categories['categories_id'] . '" ' . $parent . ' >' . self::prepare_string($cat_name) . '</category>' . "";
            }
            $categories_string .= "</categories>";
            write_cache($categories_string, 'categories.cache');
        }
        echo $categories_string;
    }

    /**Форматирование строки
     * @param $text - исходный текст
     * @return string
     */
    private function prepare_string($text)
    {
        return str_replace(array('"', "&", ">", "<", "'"), array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;'), strip_tags($text));
    }

    /**Получить список категорий, которые нужно исключить
     * @return array - массив ID категорий
     */
    public static function getExcludeCatList()
    {

        // Запрос на получение категорий и 2-го уровня
        /*   SELECT categories_id
                    FROM `categories` as ca
                    WHERE ca.categories_id IN(39)
                    OR ca.parent_id IN(39)
                    OR `parent_id` IN (SELECT categories_id FROM categories as ca2  where ca2.`parent_id` = ca.categories_id)
             */


        //исключаем ножи и одежду. лодки лас Включены (категория 939)
        $query_nozh = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` IN (505, 89, 39, 151, 46, 52, 48, 150, 3066, 25242)");
        $exclude_cat = array(
            505, 941, 1172, 1857, 1858, 1859, 4611, 4612, 4613, 4614, 4615, 4616, 4617, 4618, 4619, 4620, 4621, 4622, 4623, 4624, 4625, 4626, 4627, 4628, 4629, 4630, 4631, 4632, 4633, 4634, 4635, 4636, 4637, 4638, 4639, 4640, 4641, 4642, 4643, 8278, 8279, 8280, 8281, 8282, 8283, 8284, 8285, 8286, 8287, 8288, 8290, 8291, 8292, 8293, 8294, 2284, 2285, 2286, 2287, 2288, 2289, 2290, 2291, 2292, 2293, 2294, 2295, 2296, 2297, 2298, 2299, 2300, 2301, 2303, 2304, 2305, 2306, 2312, 3048, 3049, 3050, 3061, 3062, 3063, 2270, 2271, 2311, 19761, 8050, 8051, 8052, 8053, 8054, 21821, 21822, 21823, 10940, 22404, 21599, 21600, 21601, 21602, 21603, 21604, 21605, 21606, 21607, 21608, 21609, 21610, 21611, 21612, 21613, 21614, 21615, 21616, 10941, 10942, 10943, 10944, 20881, 21870, 21871, 21872, 21873, 20338, 20339, 20340, 20341, 20342, 20343, 20344, 20345, 20346, 20347, 20348, 13319, 13320, 21625, 21626, 20817, 20818, 20819, 20820, 20821, 20822, 20823, 20825, 4644, 4645, 4646, 4647, 4648, 4649, 4650, 4651, 4652, 4653, 4654, 4655, 4656, 4657, 4658, 5582, 5583, 5584, 9715, 9959, 9960, 9961, 9962, 9963, 9964, 9965, 9966, 9967, 9968, 9969, 10833, 10834, 10835, 10836, 10837, 10838, 10839, 12019, 12020, 13299, 13300, 13301, 13302, 13303, 13304, 13305, 13306, 13307, 13308, 13309, 13310, 13311, 13312, 13313, 13314, 13782, 13783, 13784, 13785, 13786, 16781, 16782, 16783, 16784, 16785, 17676, 17677, 17678, 17679, 17751, 17752, 17753, 17754, 17755, 17756, 17757, 17758, 17759, 17760, 17761, 17785, 17786, 17787, 17788, 17789, 17790, 17791, 17952, 17953, 17954, 17955, 17956, 17957, 17958, 18488, 18489, 18490, 19606, 19607, 19617, 19624, 19625, 19740, 19741, 19742, 19743, 19744, 19745, 19746, 19747, 19748, 19749, 19750, 19751, 19752, 19753, 19754, 19755, 19756, 20202, 20203, 20204, 20205, 20206, 20207, 20208, 21819, 21820, 20909, 20910, 20911, 20912, 22110, 21723, 21724, 21725, 21726, 21727, 21728, 21729, 20549, 20550, 20551, 20552, 21503, 10945, 10946, 10947, 10948, 10949, 12021, 12022, 12023, 12024, 12025, 16789, 17221, 17222, 18486, 18487, 19605, 7087, 7088, 9951, 22461, 22462, 22463, 16828, 16829, 16830, 16831, 16832, 13315, 13316, 13317, 13318, 1175, 1176, 1177, 1285, 1286, 1287, 1288, 1289, 1290, 1291, 1292, 1293, 1294, 1295, 1296, 1297, 1298, 1299, 1300, 1301, 1302, 1303, 1304, 1305, 1306, 1307, 1308, 1309, 1311, 1598, 1874, 1875, 1876, 1882, 1883, 1884, 1885, 1886, 1891, 1893, 1894, 1895, 1896, 1897, 1898, 1899, 1902, 1903, 1904, 1905, 1906, 1907, 1908, 1915, 2251, 3036, 3042, 3043, 3044, 3045, 3046, 3047, 3052, 3053, 3056, 3057, 3058, 3234, 347, 1873, 1920, 1921, 1922, 1923, 1924, 1925, 1926, 1927, 1928, 1929, 1930, 1931, 1932, 1933, 1934, 1935, 1936, 1937, 1938, 1939, 1940, 1941, 2253, 3059, 3060, 3037, 3039, 3040, 3041, 3038, 3051, 19618, 19619, 19620, 4575, 20796, 20797, 20798, 20799, 20800, 20801, 4576, 4524, 4525, 4526, 4527, 4577, 7026, 7027, 7031, 4578, 9443, 9444, 4579, 10063, 10064, 9925, 10061, 10062, 9926, 9946, 9947, 9948, 9927, 9942, 9943, 9928, 9944, 9945, 9929, 9940, 9941, 9930, 9934, 9935, 9931, 9936, 9937, 9932, 9938, 9939, 9933, 4580, 10936, 10937, 10938, 10939, 4581, 11796, 11797, 4582, 13516, 13517, 13518, 13519, 13520, 13521, 13522, 13523, 13524, 13525, 4583, 13538, 13539, 13540, 4584, 13541, 4585, 4586, 15817, 4587, 17782, 17783, 17784, 4588, 17842, 17843, 4589, 18491, 18492, 18543, 18518, 18519, 18544, 4590, 19609, 19610, 19542, 19611, 19612, 19543, 19549, 19550, 19544, 19545, 19546, 4591, 19630, 4592, 20811, 20812, 19770, 19771, 19772, 19773, 19774, 4593, 382, 4899, 4900, 4901, 4902, 4903, 4904, 4905, 18498, 18499, 18500, 18501, 18502, 18503, 18504, 18505, 18506, 4906, 4907, 4908, 4909, 4910, 4911, 4912, 4913, 4914, 4915, 4916, 4917, 4918, 4920, 4921, 4922, 4923, 4924, 4925, 4926, 4927, 4928, 4929, 4930, 4931, 4932, 4933, 4934, 4935, 4936, 4937, 4938, 4939, 4940, 4941, 4942, 4943, 4944, 4945, 4946, 4947, 4948, 4949, 4950, 4951, 4952, 4953, 13503, 13504, 4954, 4955, 4956, 4957, 4958, 4959, 4960, 4961, 4962, 4963, 4964, 4965, 4966, 4967, 17194, 17195, 17196, 4968, 4969, 4970, 4971, 4972, 4973, 4974, 4975, 4976, 4977, 4978, 4979, 4980, 4981, 4982, 510, 1631, 8561, 8562, 8563, 21824, 8564, 8565, 8566, 8567, 8568, 22297, 8569, 12825, 12826, 8570, 8571, 8572, 8573, 8590, 8591, 8574, 8575, 12363, 12364, 12365, 12366, 8576, 12486, 12487, 12488, 8577, 8578, 13269, 13270, 13271, 8579, 13438, 13439, 13440, 8580, 8581, 14566, 14567, 8582, 8583, 16194, 16195, 16196, 16197, 16198, 16199, 8585, 8586, 8587, 18493, 18494, 18495, 8588, 8589, 1754, 22111, 22112, 8018, 8019, 22159, 8020, 8021, 22053, 8022, 8023, 8024, 15656, 15657, 15658, 15659, 8025, 8026, 8027, 8028, 9970, 9971, 9972, 9973, 9974, 8029, 8030, 8031, 8032, 8033, 11719, 11720, 11721, 11722, 8034, 11783, 11784, 11785, 11786, 11787, 11788, 11789, 11790, 11791, 11792, 11793, 11794, 11795, 8035, 8036, 8037, 13055, 13056, 13057, 13058, 8038, 8039, 14814, 14815, 8040, 8041, 8042, 8043, 8044, 8045, 8046, 8047, 18496, 18497, 10842, 10843, 10844, 11715, 11716, 11717, 11718, 10845, 11777, 11778, 11779, 11780, 11781, 11782, 10846, 10847, 10848, 1755, 21283, 21284, 4789, 4790, 4791, 4792, 4793, 4794, 4795, 4796, 4797, 4798, 4799, 4800, 4801, 4802, 4803, 4804, 4983, 4984, 4805, 4985, 4986, 4987, 4806, 4807, 4808, 7301, 7307, 4809, 8302, 8303, 8304, 8305, 4810, 4811, 10006, 10007, 4812, 11188, 11189, 11190, 19249, 19250, 11191, 4813, 11798, 11799, 11800, 11801, 11802, 11803, 11804, 11805, 11806, 11807, 11808, 11809, 11810, 11811, 11812, 11813, 11814, 11815, 11816, 4814, 4815, 12489, 12490, 12491, 12493, 12494, 12495, 12496, 4816, 12855, 12856, 12857, 4817, 13376, 13377, 13378, 4818, 13442, 4819, 4820, 13704, 13705, 13706, 4821, 13789, 13790, 13791, 13792, 13793, 13794, 13795, 13796, 13797, 13798, 13799, 4822, 4823, 15192, 15193, 15194, 15195, 15196, 15197, 4824, 15833, 15838, 4825, 4826, 4827, 4828, 4829, 17197, 17198, 17199, 4830, 4831, 17262, 17263, 17264, 4832, 17586, 17587, 17588, 17589, 4833, 17680, 17681, 17682, 17683, 4834, 17844, 17845, 17846, 17847, 17848, 4835, 18877, 18878, 4836, 4837, 4838, 4839, 4840, 4841, 4842, 1759, 22113, 9605, 22115, 9606, 9607, 9608, 9609, 11865, 11866, 11867, 11868, 11869, 11870, 11871, 11872, 9610, 9611, 13395, 13396, 13397, 9612, 9613, 9614, 18731, 18732, 18733, 18734, 9615, 9616, 9617, 19768, 19769, 9618, 1846, 1847, 22114, 12373, 21825, 12374, 12375, 12376, 12388, 12390, 12377, 12396, 12378, 12379, 13542, 13543, 13544, 13545, 13546, 13547, 12380, 19608, 15594, 12381, 17394, 17395, 12382, 17554, 17555, 12383, 17590, 12384, 18477, 18478, 18479, 18480, 18481, 18482, 18483, 18484, 18485, 12385, 20217, 20218, 12386, 1852, 1310, 2172, 2173, 2174, 2175, 2176, 2177, 2178, 2179, 3054, 1853, 1854, 1855, 22096, 22097, 6937, 6938, 22455, 22456, 22457, 22458, 22459, 22460, 6939, 6940, 6941, 6942, 6943, 13642, 13650, 13652, 6944, 13653, 13654, 13655, 6945, 6946, 6947, 6948, 16786, 16787, 16788, 6949, 17639, 17640, 17641, 6950, 6951, 6952, 1865, 2265, 3103, 17581, 17583, 17585, 4528, 15818, 15819, 15820, 15821, 4529, 19775, 4530, 4594, 4595, 4596, 4597, 4598, 4599, 4600, 4601, 4602, 4603, 4604, 4605, 4606, 4607, 4608, 4609, 4610, 4531, 11755, 11756, 11757, 11758, 11759, 11760, 11761, 11762, 11763, 11764, 11765, 11766, 11767, 11768, 11769, 11770, 11771, 11772, 11773, 11774, 11775, 11776, 4532, 17684, 17685, 17686, 17687, 17688, 17689, 17690, 4533, 13505, 13506, 13507, 13508, 13509, 13510, 13511, 13512, 13513, 13514, 13515, 4534, 21826, 21827, 21828, 4535, 11817, 11818, 11819, 11820, 11821, 11822, 11823, 11824, 11825, 11826, 11827, 11828, 11829, 11830, 11831, 11832, 11833, 11834, 11835, 11836, 11837, 11838, 11839, 11840, 11841, 11842, 11843, 11844, 11845, 11846, 11847, 11848, 11849, 11850, 11851, 11852, 11853, 11854, 11855, 11856, 11857, 11858, 11859, 11860, 11861, 11862, 11863, 11864, 4536, 10950, 10951, 4537, 18452, 18453, 18454, 18455, 18456, 18457, 18458, 18459, 18460, 18461, 18462, 18463, 18464, 18465, 18466, 18467, 18468, 18469, 18470, 18471, 18472, 18473, 18474, 18475, 18476, 4538, 22445, 4539, 18931, 4540, 15925, 15926, 15927, 15928, 15929, 15930, 4541, 17591, 17592, 17593, 17594, 17595, 17596, 17597, 17598, 4542, 15191, 4543, 4544, 4787, 4788, 4545, 18386, 19208, 19209, 18387, 18388, 18389, 18390, 18391, 18392, 18393, 18394, 4546, 4547, 14366, 14367, 14370, 4548, 21730, 21731, 21732, 4549, 12858, 12860, 12866, 12869, 12872, 12875, 12876, 12888, 12889, 9950, 12890, 12891, 12892, 12894, 12896, 12897, 12898, 13671, 12900, 12901, 4550, 4551, 19409, 19410, 19411, 19412, 19413, 19414, 19415, 19416, 19417, 19418, 19419, 19420, 19421, 19422, 19423, 19424, 19425, 19426, 19427, 19428, 19429, 19430, 19431, 19432, 19433, 19434, 19435, 19436, 19437, 19438, 19439, 19440, 19441, 19442, 19443, 19444, 19445, 19446, 19447, 19448, 19449, 19450, 19451, 19452, 19453, 19454, 19455, 19456, 19457, 19458, 19459, 19460, 4552, 19975, 4553, 12477, 12478, 12480, 12481, 12483, 12484, 12485, 4554, 20810, 4555, 15921, 15922, 15923, 15924, 4556, 12057, 12058, 4557, 13379, 13380, 13381, 13382, 13386, 13387, 13388, 13389, 4558, 12912, 12913, 12914, 12915, 12916, 12917, 12918, 4559, 13343, 13344, 13345, 13346, 13348, 13349, 13350, 13351, 12919, 13398, 13399, 13400, 13401, 13402, 13404, 13405, 13407, 13408, 13410, 13411, 13412, 13414, 13415, 13416, 13417, 12921, 12922, 12923, 13419, 12924, 4560, 4561, 13365, 13366, 13367, 13368, 13369, 4562, 20764, 4563, 22295, 22296, 4564, 22439, 22440, 4565, 4566, 20635, 20636, 20637, 4567, 20813, 4568, 14568, 14569, 14570, 14571, 4569, 12341, 12342, 19210, 19211, 12343, 12344, 12345, 12346, 12347, 12348, 12349, 12350, 12351, 12352, 12353, 12354, 12355, 12356, 12357, 12358, 12359, 12360, 12361, 12362, 4570, 22116, 22117, 22118, 22119, 4571, 19473, 19474, 19475, 19476, 4572, 20963, 4573, 21504, 21505, 21506, 21507, 4574, 21894, 13282, 13283, 13284, 13285, 13286, 13287, 13288, 13289, 13290, 21903, 16724, 16725, 16726, 16727, 16728, 16729, 16730, 16661, 16738, 16739, 16740, 16741, 16742, 16743, 16744, 16745, 16746, 16747, 16662, 16755, 16756, 16757, 16758, 16759, 16760, 16761, 16762, 16763, 16764, 16663, 16664, 16665, 16773, 16774, 16775, 16776, 16777, 16778, 16779, 16780, 16666, 16023, 16686, 16687, 16667, 16688, 16689, 16690, 16691, 16692, 16693, 16694, 16695, 16696, 16697, 16668, 16698, 16699, 16700, 16701, 16702, 16703, 16704, 16705, 16706, 16707, 16708, 16709, 16669, 16670, 16671, 16710, 16711, 16712, 16713, 16714, 16715, 16672, 16024, 16027, 16673, 16028, 16029, 16030, 16031, 16032, 16033, 16674, 16034, 16035, 16036, 16675, 16676, 16677, 16064, 16065, 16066, 16067, 16068, 16069, 16678, 16025, 16047, 16048, 16049, 16039, 16050, 16051, 16052, 16040, 16053, 16054, 16055, 16041, 16056, 16057, 16058, 16042, 16059, 16060, 16061, 16043, 16062, 16063, 16044, 16045, 16046, 16679, 16716, 16717, 16718, 16719, 16720, 16721, 16722, 16723, 16680, 16731, 16732, 16733, 16734, 16735, 16736, 16737, 16681, 16748, 16749, 16750, 16751, 16752, 16753, 16754, 16682, 16683, 16684, 16765, 16766, 16767, 16768, 16769, 16770, 16771, 16772, 16685, 16026, 25183
        );
        //Те, которые удаляли
        //        89, 39, 151, 46, 52, 48, 150, 3066, 25242

        /*    $include_cat = array(939);

        if(count($include_cat) > 0){
            $exclude_cat = $include_cat;
        }*/
        // 1 и 2 уровень
        $first =
            tep_db_query('SELECT categories_id
                  FROM `categories` as ca
                  WHERE ca.parent_id IN(' . implode(',', $exclude_cat) . ')
                  ');

        while ($cat = tep_db_fetch_array($first)) {
            $exclude_cat[] = $cat['categories_id'];
            $first_ar[] = $cat['categories_id'];
        }

        // Запрос на получние категорий 3-го
        $second =
            tep_db_query('SELECT categories_id
                  FROM `categories` as ca
                  WHERE ca.parent_id IN(' . implode(',', $first_ar) . ')');

        while ($cat = tep_db_fetch_array($second)) {
            $exclude_cat[] = $cat['categories_id'];
            $second_ar[] = $cat['categories_id'];
        }

        $third =
            tep_db_query('SELECT categories_id
                  FROM `categories` as ca
                  WHERE ca.parent_id IN(' . implode(',', $second_ar) . ')');

        while ($cat = tep_db_fetch_array($third)) {
            $exclude_cat[] = $cat['categories_id'];
        }
        return $exclude_cat;
    }

    /**Получить список категорий, которые нужно исключить
     * @return array - массив ID категорий
     */
    public static function getIncludeCatList()
    {
        $include_cat = array();

        return $include_cat;
    }

    /**Рендер предложений для Прайс-листа
     * @param $currencies - валюта
     * @param array $exclude_cat - категории для исключений
     * @param int $limit - максимальное количество товаров
     */
    public static function showOffers($currencies, $exclude_cat = null, $limit = 0, $include_cat = null)
    {
        echo "<offers>";

        $offers = array();

        $currencies->currencies['RUR']['symbol_right'] = '';
        $currencies->currencies['RUR']['thousands_point'] = '';
        self::$has_categories_sales = self::getHasCategoriesSales();
        //if (!read_cache($offers, 'offers_yml.cache', self::$cache_time)) {
        if (!is_null($exclude_cat)) {
            $query = "SELECT STRAIGHT_JOIN " .
                "p.products_quantity_order_min, 
                IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
                p.products_id,pd.products_name, p.products_to_xml, p.supplier_id, p.products_quantity,p.products_price,p.products_tax_class_id,pc.categories_id,p.manufacturers_id,
          m.manufacturers_name,p.products_model,p.products_model_tag,pd.products_description, p.products_weight, p.supplier_id, 
          p.products_image,
          p.products_image_med,
          p.products_image_lrg,
          p.products_image_sm_1,
          p.products_image_xl_1,
          p.products_image_sm_2,
          p.products_image_xl_2,
          p.products_image_sm_3,
          p.products_image_xl_3,
          p.products_image_sm_4,
          p.products_image_xl_4,
          p.products_image_sm_5, 
          p.products_image_xl_5,
          p.products_image_sm_6,
          p.products_image_xl_6
            FROM " . TABLE_PRODUCTS . " p INNER JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS pc
    on p.products_quantity > 0
     and p.products_to_xml ='1'
      and p.products_status = '1'
       and p.products_price > 1000
       and pc.products_id = p.products_id
        and pc.categories_id NOT IN (" . implode(',', $exclude_cat) . ")
            LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON pd.products_id = p.products_id
            INNER JOIN " . TABLE_CATEGORIES . " AS c ON c.categories_id = pc.categories_id and c.categories_status = '1'
            LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON m.manufacturers_id = p.manufacturers_id
            left join " . TABLE_SPECIALS . " AS s ON p.products_id = s.products_id
             GROUP BY p.products_id " . ($limit > 0 ? "Limit " . $limit : "");
        }
        $products_query = tep_db_query($query);
        //     and pc.products_id = p.products_id and pc.categories_id NOT IN (" . implode(',', $exclude_cat) . ")
        /*
             * исключаем одежду без параметра размер
             * Одежда,Обувь,очки
             * */
        $query_clothes = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` IN (43,351)");
        $clothes_cat = array(43, 351);
        $child_cats = array();
        while ($cat = tep_db_fetch_array($query_clothes)) {
            $child_cats[] = $cat['categories_id'];
            $clothes_cat[] = $cat['categories_id'];
        }
        $query_child_clothes = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` IN (" . implode(',', $child_cats) . ")");
        while ($cat = tep_db_fetch_array($query_child_clothes)) {
            $clothes_cat[] = $cat['categories_id'];
        }
        $param_names_query = tep_db_query("SELECT specifications_id, specification_name FROM `specification_description`  ");
        $param_names = array();
        while ($param = tep_db_fetch_array($param_names_query)) {
            $param_names[$param['specifications_id']] = $param['specification_name'];
        }
        $start = microtime(1);
        //Формируем список с полностью актуальными ценами
        $products = array();
        $product_ids = array();
        while ($product = tep_db_fetch_array($products_query)) {
            $products[] = $product;
            $product_ids[] = $product['products_id'];
        }
        self::$product_info_hrefs = tep_product_info_href_links($product_ids, "");
        self::$has_products_specification = self::getHasProductsSpecification($product_ids);

        foreach ($products as $product) {
            $ar = array(
                167, 178, 179, 180, 181, 144990, 250883, 250885, 144990, 250886, 250887, 250888, 250889,
                250890
            );
             $suppliers_id_list = array(17, 18, 64, 28, 43);  //43 - икс ривер(лас), 18 - RS, 64 - bemal, 56- гретис, 26 - волжанка, 17 - гриффон, 25 - микадо, 15 - нормарк, 28 - земекс выбираем поставщиков
             if ((!in_array($product['products_id'], $ar)) and ($product['products_price']>2500)
              and (in_array($product['supplier_id'], $suppliers_id_list))
               and ($product['products_quantity'] > 100))
                {
                 echo self::getOffer($product, $currencies, $clothes_cat, $param_names);
             }
            //включить в фид по айди без условий
            $prods_to_feed = array(250896);
            if (in_array($product['products_id'], $prods_to_feed))  {
                echo self::getOffer($product, $currencies, $clothes_cat, $param_names);
            }
        }
        if (self::$replace_query_ind > 0) {
            tep_db_query("REPLACE INTO yandex_market (`products_id`,`before`,`after`,`cat_id`) VALUES " . implode(',', self::$replace_query));
        }
        //  $test = '';
        //   write_cache($test, 'offers_yml.cache');
        //}
        //  else {
        //     //Только обновляем цены
        //     self::updatePrices($currencies, $exclude_cat);
        // }

        echo "</offers>";
    }


    /**Рендер подарков
     */
    public static function showGifts()
    {
        echo "<gifts>
          <gift id=\"1\">
            <name>Блесна Микадо на выбор магазина</name>
            <picture>https://static.yourfish.ru/images/mikado/middle/540.png</picture>
          </gift>
        </gifts>";
    }

    /**Рендер Промоакций для Прайс-листа
     */
    public static function showPromos()
    {
        $purchase_products = '<product offer-id="' . implode('"/>' . "\r\n" . '<product offer-id="', self::$promo_products) . '"/>';
        echo "<promos>
               <promo id=\"PromoGift\" type=\"gift with purchase\"> 
                  <description>Купите этот товар и получите подарок.</description>
                  <purchase> 
                    {$purchase_products}
                  </purchase>
                  <promo-gifts>
                    <promo-gift gift-id=\"1\"/>
                  </promo-gifts>
               </promo>
            </promos>";
    }

    /**Рендер предложений для прайс листа, с обновлением только цен
     * @param $currencies - валюта
     * @param array $exclude_cat - массив id категорий для исключений
     */
    private function updatePrices($currencies, $exclude_cat = array())
    {
        $query = "SELECT p.*,ym.before, ym.after,ym.cat_id as categories_id
            FROM " . TABLE_PRODUCTS . " as p
            INNER JOIN yandex_market as ym on ym.products_id = p.products_id
            WHERE p.products_quantity > 0 and p.products_status = '1' AND p.products_price > 0 and 
            ym.cat_id NOT IN (" . implode(',', $exclude_cat) . ")";
        $products_query = tep_db_query($query);
        while ($product = tep_db_fetch_array($products_query)) {
            $priceList = self::getPrices($currencies, $product);
            $price = $priceList['current'];
            $oldPriceTag = $priceList['old'];
            $price = "<price>{$price}</price>{$oldPriceTag}";
            echo $product['before'] . $price . $product['after'];
        }
    }

    /** Получить объект запроса категорий
     * @param $languages_id - язык сайта
     * @return resource - объект запроса БД
     */
    private function getCategoriesQuery($languages_id, $exclude_cat = null, $include_cat = null)
    {
        if (!is_null($exclude_cat)) {
            $query = "SELECT c.categories_id, cd.categories_name,cd.categories_yandex_name, c.parent_id 
            FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            WHERE c.categories_id = cd.categories_id  " .
                " AND c.categories_id NOT IN (" . implode(',', $exclude_cat) . ") ";
        } else {
            $query = "SELECT c.categories_id, cd.categories_name,cd.categories_yandex_name, c.parent_id 
            FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            WHERE c.categories_id = cd.categories_id  " .
                " AND c.categories_id IN (" . implode(',', $include_cat) . ") ";
        }
        $query .= " and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name";
        return tep_db_query($query);
    }

    /**Очищает странны из заголовка
     * @param $text
     * @return string
     */
    private function remove_countries($text)
    {
        return str_replace(array('(Россия)', "ВСЯ РОССИЯ"), '', $text);
    }

    /**Получить предложение для прайс-листа
     * @param $product - товар
     * @param $currencies - валюта
     * @param $clothes_cat - категории одежды
     * @param $param_names - наименования параметров
     * @return string
     */
    private function getOffer($product, $currencies, $clothes_cat, $param_names)
    {

        $available = "true";
        $product_link = self::$product_info_hrefs[$product['products_id']];

        $prod_name = trim($product['products_name']);
        $calc_name = '';
        if (!empty($prod_name)) {
            $calc_name = self::remove_countries(self::prepare_string($product['products_name']));
            $name = '<name>' . $calc_name . '</name>';
        } else {
            return false;
        }

        $exclude_words = array(
            'яндкес',
            'наложенным',
            'наложенный',
            'доставка',
            //            'Руси'
        );

        foreach ($exclude_words as $exclude_word) {
            $pos = stripos($product['products_description'], $exclude_word);
            if ($pos !== false) {
                return false;
            }
        }
        $ar = array(
            167, 178, 179, 180, 181, 144990, 250883, 250885, 250886, 250887, 250888, 250889,
            250890
        );
        if (in_array($product['products_id'], $ar)) {
            return false;
        }

        $priceList = self::getPrices($currencies, $product);

        $price = $priceList['current'];
        $oldPriceTag = $priceList['old'];
        $images = self::getProductImages($product);
        if (empty($images)) {
            return false;
        }
        $weight = self::getProductWeight($product['products_weight']);

        $vendor = '';
        if (!empty($product['manufacturers_name'])) {
            if ($product['manufacturers_name'] != 'Россия') {
                $vendor = '        <vendor>' . self::prepare_string($product['manufacturers_name']) . '</vendor>' . "";
            }
        }

        $vendorCode = '';
        if (!empty($product['products_model'])) {
            $vendorCode = "        <vendorCode>" . trim(str_replace(array("\0"), '', $product['products_model'])) . "</vendorCode>";
        }

        $description = '';
        if (!empty($product['products_description'])) {
            $description = "       <description>" . self::prepare_description($product['products_description']) . "</description>";
        }

        $min_quantity = '';
        if (!empty($product['products_quantity_order_min']) && $product['products_quantity_order_min'] > 1) {
            $min_quantity = " Мин. кол-во " . $product['products_quantity_order_min'] . "шт.";
        }
        $isClothes = in_array($product['categories_id'], $clothes_cat) ? true : false;
        $params = self::getParams($product['products_id'], $isClothes, $param_names);
        if ($params === false) {
            return false;
        }
        if (!empty($weight)) {
            $weight = "<weight>{$weight}</weight>";
        }

        if ($product['products_id'] == '144990' or $product['products_id'] == 144990) {
            return false;
        }

        $before = "
        <offer id=\"" . $product['products_id'] . "\" available=\"{$available}\" > 
            {$name}
            <url>{$product_link}</url>
            <model>{$calc_name}</model>";
        $before_input = tep_db_input($before);
        $price = "<price>{$price}</price>{$oldPriceTag}";
        $after = "<currencyId>RUR</currencyId>
            <categoryId>{$product['categories_id']}</categoryId>
            {$images}
            <store>true</store>
            <pickup>true</pickup>
            <delivery>true</delivery>
            {$weight}
            {$vendor}
            {$vendorCode}
            {$description}
            {$params}
            <sales_notes></sales_notes>
        </offer>
        ";
        $after_input = tep_db_input($after);
        self::$replace_query[] = "(" . $product['products_id'] . ",'{$before_input}','{$after_input}'," . $product['categories_id'] . ")";
        self::$replace_query_ind++;
        if (self::$replace_query_ind > self::$max_replace_rows) {
            tep_db_query("REPLACE INTO yandex_market (`products_id`,`before`,`after`,`cat_id`) VALUES " . implode(',', self::$replace_query));
            self::$replace_query_ind = 0;
            self::$replace_query = array();
        }
        if ($priceList['current'] < 20000) {
            return $before . $price . $after;
        }
    }

    /**
     * Получает список категорий к каторым привязаны скидки
     * @return array|null - Массив Id категорий
     */
    private function getHasCategoriesSales()
    {
        $sale_query = tep_db_query("select sale_categories_all from " . TABLE_SALEMAKER_SALES . " 
        where sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and 
    (sale_date_end >= now() or sale_date_end = '0000-00-00') ");
        $category_ids = array();
        while ($sales_categories = tep_db_fetch_array($sale_query)) {
            $category_ids = array_merge($category_ids, explode(',', $sales_categories['sale_categories_all']));
        }
        $category_ids = array_flip(array_unique($category_ids));
        unset($category_ids['']);
        $category_ids_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " 
        where categories_id IN (" . implode(",", $category_ids) . ") and categories_status='1' ");
        $category_ids = array();
        while ($category = tep_db_fetch_array($category_ids_query)) {
            $category_ids[] = $category['categories_id'];
        }
        return $category_ids;
    }

    /**Получаем массив спецификаций товаров
     * @param $product_ids - список ID категорий
     * @return array
     */
    private function getHasProductsSpecification($product_ids)
    {
        $spec_query = tep_db_query("SELECT specifications_id,specification,products_id 
        FROM products_specifications
          WHERE specifications_id <> 0
          and products_id IN (" . implode(',', $product_ids) . ")  
          AND specification <> '' ");
        $spec_items = array();
        while ($spec = tep_db_fetch_array($spec_query)) {
            $new_spec = array(
                'specifications_id' => $spec['specifications_id'],
                'specification' => $spec['specification'],
            );
            if (isset($spec_items[$spec['products_id']])) {
                $spec_items[$spec['products_id']][] = $new_spec;
            } else {
                $spec_items[$spec['products_id']] = array($new_spec);
            }
        }
        return $spec_items;
    }

    /**
     * Проверяем, имеется ли скидка в указанной категории
     * @param $cat_id - ID категории
     * @return bool
     */
    private function hasCategorySales($cat_id)
    {

        if (isset(self::$has_categories_sales[$cat_id])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Получаем цену товара
     * @param $currencies - валюта
     * @param $product - товар
     * @return array - возвращает 2 цены, Old и Current
     */
    private function getPrices($currencies, $product)
    {
        $product_tax = $product['products_tax_class_id'];
        $product_price = $product['products_price'];
        $oldPriceTag = '';

        if ($new_price = tep_get_quick_products_special_price($product, self::hasCategorySales($product['categories_id']))) {

            $tax_rate = tep_get_tax_rate($product_tax);

            $price = trim($currencies->display_price_nodiscount($new_price, $tax_rate));

            $oldPrice = trim($currencies->display_price_nodiscount($product_price, $tax_rate));

            if (!empty($oldPrice)) {
                $oldPriceTag = "  <oldprice>{$oldPrice}</oldprice>";
            }
            if (floatval($price) / floatval($oldPrice) > 0.94) {
                $oldPriceTag = '';
            }
        } else {
            $price = trim($currencies->display_price($product_price, tep_get_tax_rate($product_tax)));
        }
        //Добавляем товар в акцию
        //        if ($price >= 2000 and $price < 20000) {
        //            self::$promo_products[] = $product['products_id'];
        //        }

        return array('old' => $oldPriceTag, 'current' => $price);
    }

    /**Получить изображения товара
     * @param $product - товар
     * @return bool|string
     */
    private function getProductImages($product)
    {
        $images = array();
        $suffix = 'https://yourfish.ru/images/';
        if (!empty($product['products_image_lrg'])) {
            $images[] = self::prepare_image($suffix, $product['products_image_lrg']);
        } elseif (!empty($product['products_image_med'])) {
            $images[] = self::prepare_image($suffix, $product['products_image_med']);
        } elseif (!empty($product['products_image'])) {
            $images[] = self::prepare_image($suffix, $product['products_image']);
        }

        for ($i = 1; $i < 7; $i++) {
            if (!empty($product['products_image_xl_' . $i])) {
                $images[] = self::prepare_image($suffix, $product['products_image_xl_' . $i]);
            } elseif (!empty($product['products_image_sm_' . $i])) {
                $images[] = self::prepare_image($suffix, $product['products_image_sm_' . $i]);
            }
        }
        if (empty($images)) {
            return false;
        }
        return implode("", array_unique($images));
    }

    /**
     * Избавляемся от лишних символов в ссылке
     * @param $suffix - ссылка до дирректории с изображениями
     * @param $img - ссылка на изображение
     * @return string
     */
    private function prepare_image($suffix, $img)
    {
        if (stripos($img, ',') !== false) {
            $img = stristr($img, ',', true);
        }
        return '<picture>' . $suffix . str_replace(' ', '%20', $img) . '</picture>';
    }

    /**
     * Получаем корректный вес товара для прайс-листа
     * @param $products_weight - вес товара
     * @return float
     */
    private function getProductWeight($products_weight)
    {
        $products_weight = floatval($products_weight);
        $weight = $products_weight / 1000;
        return $weight;
    }

    /**
     * Формируем описания для прайс-листа
     * @param $text - описание товара
     * @return string
     */
    private function prepare_description($text)
    {
        $exclude = array(
            "скидка", "распродажа", "дешевый", "подарок", "бесплатно", "акция", "специальная цена",
            "новинка", "new", "аналог", "заказ", "хит"
        );
        if (stripos($text, '<table') !== false) {
            $text = stristr($text, '<table', true);
        }
        $text = trim(strip_tags($text, '<h3><ul><li>'));
        return '<![CDATA[' . mb_substr(str_ireplace($exclude, '', $text), 0, 2980) . ']]>';
    }

    /**
     * Получаем список параметров товара
     * @param $product_id - ID Категорий
     * @param $isClothes - является ли одеждой
     * @param $param_names - список параметров
     * @return bool|string
     */
    function getParams($product_id, $isClothes, $param_names)
    {
        if (!isset(self::$has_products_specification[$product_id])) {
            return '';
        }

        $product_params = self::$has_products_specification[$product_id];
        $params = '';
        $haveSize = false;
        foreach ($product_params as $param) {
            $param_name = $param_names[$param['specifications_id']];
            if ($param_name == 'Размер') {
                $haveSize = true;
            }
            $params .= '        <param name="' . $param_name . '">' . self::prepare_string($param['specification']) . '</param>' . "
            ";
        }
        if ($isClothes && !$haveSize) {
            return false;
        } else {
            return $params;
        }
    }

    /**
     *Рендер подвала
     */
    public static function showFooter()
    {
        echo " 
			</shop>
		</yml_catalog>";
    }
}
/*require('includes/application_top.php');
$exclude_cat = YandexMarket::getExcludeCatList();
//    $include_cat = YandexMarket::getIncludeCatList();
//YandexMarket::showHeader();
//$test = YandexMarket::showCategories($languages_id, $exclude_cat, null);
echo '<pre>';
print_r($exclude_cat);
echo '</pre>';*/

define('DIR_FS_CACHE', __DIR__ . '/cache/');
require(__DIR__ . '/includes/application_top.php');
include(DIR_WS_FUNCTIONS . 'cache.php');
if (strripos($_SERVER['REQUEST_URI'], '.zip') == false) {
    $filename = 'yandex_market3.gz';
} else {
    $filename = 'yandex_market3.zip';
}

header("Content-Type: application/zip");
header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");

//if (!read_cache($cache_output, 'yandex_market2.zip', 6 * 60)) {
mb_internal_encoding('UTF-8');
//Рендер прас-листа
ob_start();
$exclude_cat = YandexMarket::getExcludeCatList();
//    $include_cat = YandexMarket::getIncludeCatList();
YandexMarket::showHeader();
YandexMarket::showCategories($languages_id, $exclude_cat, null);
YandexMarket::showOffers($currencies, $exclude_cat, 0, null);
//    YandexMarket::showGifts();
//   YandexMarket::showPromos();
YandexMarket::showFooter();
$cache_output = ob_get_contents();
ob_end_clean();
//Архивируем прайс-лист в zip и gzip
file_put_contents(DIR_FS_CACHE . 'yandex_market_tmp3.xml', $cache_output);
shell_exec('cd ' . DIR_FS_CACHE . ' && rm -f yandex_market3.zip && zip yandex_market3.zip yandex_market_tmp3.xml');
shell_exec('cd ' . DIR_FS_CACHE . ' && rm -f yandex_market3.gz && gzip -c yandex_market_tmp3.xml > yandex_market3.gz');

//}
header('Content-Length: ' . filesize(DIR_FS_CACHE . $filename));
readfile(DIR_FS_CACHE . $filename);
clearstatcache();
ini_set('zlib.output_compression', 'On');
exit;
