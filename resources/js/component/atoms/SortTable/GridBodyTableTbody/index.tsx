import React from 'react';
import { SortTableGridBodyTableTbody } from '../../../../props/props';

function buildTds(data) {
  if (typeof data === 'undefined') {
    return '<div/>';
  }
  return data.map((item, idx) => (
    <td key={idx} className={item.className}>
      {item.content}
    </td>
  ));
}

const GridBodyTableTbody: React.FC<React.PropsWithChildren<SortTableGridBodyTableTbody>> = (
  props: SortTableGridBodyTableTbody,
): JSX.Element => (
  <tbody role="alert" aria-live="polite" aria-relevant="all">
    {props.datas.map((data, idx) => (
      <tr key={idx} className="">
        {buildTds(data)}
      </tr>
    ))}
  </tbody>
);

export default GridBodyTableTbody;
