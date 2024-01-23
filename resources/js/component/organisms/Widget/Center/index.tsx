import React from 'react';
import { WidgetCenterProps } from '../../../../props/props';
import WidgetLoader from '../../../molecules/WidgetLoader';

const WidgetCenter: React.FC<React.PropsWithChildren<WidgetCenterProps>> = (
  props: WidgetCenterProps
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
  if (typeof props.data.widgets.center === 'undefined') {
    return <></>;
  }

  return (
    <div className="content_center">
      {props.data.widgets.center.map((item, idx) => (
        <WidgetLoader key={idx} data={item} pagedata={props.pagedata} />
      ))}
    </div>
  );
};
export default WidgetCenter;
