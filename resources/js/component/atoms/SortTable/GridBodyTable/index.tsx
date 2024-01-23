import React from 'react';
import { SortTableGridBodyTable } from '../../../../props/props';
import GridBodyTableTbody from '../GridBodyTableTbody';
import GridBodyTableThead from '../GridBodyTableThead';

const GridBodyTable: React.FC<React.PropsWithChildren<SortTableGridBodyTable>> = (
  props: SortTableGridBodyTable,
): JSX.Element => (
  <table
    className={`table table-striped dataTable no-more-tables ${props.className}`}
    id={props.id}
    aria-describedby="example2_info"
  >
    <GridBodyTableThead ths={props.ths} sort={props.sort} />
    <GridBodyTableTbody datas={props.datas} />
  </table>
);

export default GridBodyTable;
