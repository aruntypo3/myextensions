<pre>
    <?php
# include parseCSV class.
    require_once('parsecsv.lib.php');


# create new parseCSV object.
    $csv = new parseCSV();


# if sorting is enabled, the whole CSV file
# will be processed and sorted and then rows
# are extracted based on offset and limit.
#
# if sorting is not enabled, then the least
# amount of rows to satisfy offset and limit
# settings will be processed. this is useful
# with large files when you only need the
# first 20 rows for example.
    $csv->sort_by = 'title';


# offset from the beginning of the file,
# ignoring the first X number of rows.
    $csv->offset = 1;

# limit the number of returned rows.
    $csv->limit = 200;


# Parse '_books.csv' using automatic delimiter detection.
    $csv->auto('ITEM_12 data.csv');


# Output result.
    //print_r($csv->data);
    //key=>dbcolomn name
    //value=>csv colomun name
    $mappArray = array(
        'item_number' => 'item_number',
        'item_name' => 'item_name',
        'buy' => 'buy',
        'sell' => 'sell',
        'inventory' => 'inventory',
        'item_pic' => 'item_picture',
        'description' => 'description',
        'custlist_1' => 'custom_list_1',
        'metal' => 'custom_list_2',
        'brand' => 'custom_list_3',
        'stone_details' => 'custom_field_1',
        'show_onsite' => 'custom_field_2',
        'stone_details' => 'custom_field_1',
        'sellingprice' => 'selling_price',
    );
$insertArray = array();
    foreach ($csv->data as $key => $value) {
        foreach ($value as $pin => $data) {
            $searchValue = strtolower(preg_replace('/\s+/', '_', $pin));
            $dbColName = array_search($searchValue, $mappArray);
            $insertArray[$key][$dbColName] = $data;
            
        }
    }
    print_r($insertArray);
    ?>
