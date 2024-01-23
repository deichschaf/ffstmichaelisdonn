import React from 'react';
import { SortTableGridBodyTablePagination } from '../../../../props/props';
import FAS from '../../Icon/FAS';

const GridBodyTablePagination: React.FC<
  React.PropsWithChildren<SortTableGridBodyTablePagination>
> = (props: SortTableGridBodyTablePagination): JSX.Element => (
  <div className="row">
    <div className="col-md-12">
      <div className="dataTables_paginate paging_bootstrap pagination">
        <ul>
          {/* <li className="prev disabled">
              <a href="#">
                <FAS className="chevron-left" />
              </a>
            </li>
            <li className="active">
              <a href="#">1</a>
            </li>
            <li>
              <a href="#">2</a>
            </li>
            <li>
              <a href="#">3</a>
            </li>
            <li>
              <a href="#">4</a>
            </li>
            <li>
              <a href="#">5</a>
            </li>
            <li className="next">
              <a href="#">
                <FAS className="chevron-right" />
              </a>
            </li> */}
        </ul>
      </div>
      <div className="dataTables_info" id="example2_info">
        Showing <b>{props.count}</b> entries
      </div>
    </div>
  </div>
);

export default GridBodyTablePagination;
