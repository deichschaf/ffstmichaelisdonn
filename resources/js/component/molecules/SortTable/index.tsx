import React from 'react';
import { SortTableProps } from '../../../props/props';
import GridBodySort from '../../atoms/SortTable/GridBodySort';
import GridBodyTable from '../../atoms/SortTable/GridBodyTable';
import GridBodyTablePagination from '../../atoms/SortTable/GridBodyTablePagination';
import SortTableHeader from '../../atoms/SortTable/Header';

const SortTable: React.FC<React.PropsWithChildren<SortTableProps>> = (
  props: SortTableProps,
): JSX.Element => {
  const numRows = props.datas.length;
  return (
    <div className="grid simple">
      <SortTableHeader showTableButtons={false} lable={props.headline} />
      <div className="grid-body">
        <div className="dataTables_wrapper form-inline" id={props.table_id} role="grid">
          <GridBodySort
            showPaginationList={props.showPaginationList}
            showSearchBox={props.showSearchBox}
            sort={props.sort}
          />
          <GridBodyTable
            id={props.table_id}
            sort={props.sort}
            ths={props.ths}
            className={props.className}
            datas={props.datas}
          />
          <GridBodyTablePagination count={numRows} />
        </div>
      </div>
    </div>
  );
};

export default SortTable;
