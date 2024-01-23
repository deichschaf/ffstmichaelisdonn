import React from 'react';
import { WidgetTopProps } from '../../../../props/props';
import WidgetLoader from '../../../molecules/WidgetLoader';

const WidgetTop: React.FC<React.PropsWithChildren<WidgetTopProps>> = (
  props: WidgetTopProps,
): JSX.Element => {
  if (typeof props.pagedata === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data.widgets === 'undefined') {
    return <></>;
  }
  if (typeof props.pagedata.data.widgets.top === 'undefined') {
    return <></>;
  }

  return (
    <div className="content_top">
      {props.pagedata.data.widgets.top.map((item, idx) => (
        <WidgetLoader key={idx} data={item} pagedata={props.pagedata} />
      ))}
    </div>
  );
};
export default WidgetTop;
