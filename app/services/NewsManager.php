<?php
class NewsManager
{
	public static function searchNews($input)
	{
		$orderBy = self::searchAdminGameSortBy($input);
		$data = AdminNew::where(function ($query) use ($input)
		{
			if ($input['type_new_id'] != 0) {
				$query = $query->where('type_new_id', $input['type_new_id']);
			}
			if ($input['title']) {
				$query = $query->where('title', 'like', '%'.$input['title'].'%');
			}
			if($input['start_date'] != ''){
				$query = $query->where('start_date', '>=', $input['start_date']);
			}
			if($input['end_date'] != ''){
				$query = $query->where('start_date', '<=', $input['end_date']);
			}
			if($input['status_seo'] != '')
			{
				$listSeo = AdminSeo::where('model_name', 'AdminNew')->where('status_seo', $input['status_seo'])->lists('model_id');
                $query = $query->whereIn('id', $listSeo);
			}


		})->orderBy($orderBy[0], $orderBy[1])->paginate(PAGINATE);
		return $data;
	}
	public static function searchAdminGameSortBy($input)
	{
		$sortBy = 'id';
		$sort = 'desc';
		if($input['sortByCountView'] != '') {
			if($input['sortByCountView'] == 'count_view_asc') {
				$sortBy = 'count_view';
				$sort = 'asc';
			}
			if($input['sortByCountView'] == 'count_view_desc') {
				$sortBy = 'count_view';
				$sort = 'desc';
			}
		}
		return [$sortBy, $sort];
	}
}