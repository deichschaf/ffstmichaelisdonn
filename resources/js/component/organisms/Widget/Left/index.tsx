import React from 'react';
import { WidgetLeftProps } from '../../../../props/props';
import WidgetLoader from '../../../molecules/WidgetLoader';

const WidgetLeft: React.FC<React.PropsWithChildren<WidgetLeftProps>> = (
  props: WidgetLeftProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.data.widgets === 'undefined') {
    return <></>;
  }
  if (typeof props.data.widgets.left === 'undefined') {
    return <></>;
  }

  return (
    <div className="content_left">
      {props.data.widgets.left.map((item, idx) => (
        <WidgetLoader key={idx} data={item} pagedata={props.pagedata} />
      ))}
    </div>
  );
};
export default WidgetLeft;
