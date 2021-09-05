namespace App\Methods;


use Illuminate\Support\Facades\DB;

class DBQ
{
	public static function select_records_where($tb_name, $where, $orderBy = [['id', 'desc']], $offset = 0, $limit = 10) {
		// $where must be array of array -> [['id', 12], [...]]
		$records = DB::table($tb_name)
			->where($where)
			->offset($offset)
			->limit($limit);
		foreach ($orderBy as $index => $item) {
			$records = $records->orderBy($item[0], $item[1]);
		}
		$records = $records->get()->toArray();
		$records = objectToArray($records);
		return $records;
	} // done
	
	public static function select_record_by_id($tb_name, $record_id) {
		return self::select_records_where($tb_name, [['id', $record_id]]);
	} // done
	
	public static function select_last_record($tb_name) {
		$record = DB::table($tb_name)
			->orderBy('id', 'desc')
			->first();
		return (array) $record;
	} // done
	
	//==============================
	
	public static function update_record_where($tb_name, $where, $updates) {
		$query = DB::table($tb_name)
			->where($where)
			->update($updates);
		return $query;
	} // done
	
	public static function update_record_by_id($tb_name, $record_id, $updates) {
		return self::update_record_where($tb_name, [['id', $record_id]], $updates);
	} // done
	
	//==============================
	
	public static function delete_records_where($tb_name, $where, $limit = 0) {
		// $where must be array of array -> [['id', 12], [...]]
		$query = DB::table($tb_name)
			->where($where);
		if ($limit > 0) $query = $query->limit($limit);
		$query = $query->delete();
		return $query;
	} // done
	
	public static function delete_record_by_id($tb_name, $record_id) {
		return self::delete_records_where($tb_name, [['id', $record_id]], 1);
	} // done
}
