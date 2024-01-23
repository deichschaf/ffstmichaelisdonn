import React from 'react';
import { WidgetRightProps } from '../../../../props/props';
import WidgetLoader from '../../../molecules/WidgetLoader';

const WidgetRight: React.FC<React.PropsWithChildren<WidgetRightProps>> = (
  props: WidgetRightProps
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

  if (typeof props.pagedata.data.widgets.right === 'undefined') {
    return <></>;
  }

  return (
    <div className="content_right">
      {props.pagedata.data.widgets.right.map((item, idx) => (
        <WidgetLoader widget={props.widget} key={idx} data={item} pagedata={props.pagedata} />
      ))}
    </div>
  );
};
export default WidgetRight;
