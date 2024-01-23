import React from 'react';
import { WidgetBottomProps } from '../../../../props/props';
import WidgetLoader from '../../../molecules/WidgetLoader';

const WidgetBottom: React.FC<React.PropsWithChildren<WidgetBottomProps>> = (
  props: WidgetBottomProps,
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
  if (typeof props.data.widgets.bottom === 'undefined') {
    return <></>;
  }

  return (
    <div className="content_bottom">
      {props.data.widgets.bottom.map((item, idx) => (
        <WidgetLoader key={idx} data={item} pagedata={props.pagedata} />
      ))}
    </div>
  );
};
export default WidgetBottom;
