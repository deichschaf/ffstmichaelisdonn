import React from 'react';
import { BlackdayProps } from '../../../props/props';
import BlackdayMessage from '../../atoms/BlackdayMessage';

const Blackday: React.FC<React.PropsWithChildren<BlackdayProps>> = (
  props: BlackdayProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.blackday === 'undefined') {
    return <></>;
  }

  return props.data.blackday.map((item, idx) => (
    <BlackdayMessage key={idx} data={item} homepage_owner={props.data.homepage_owner} />
  ));
};
export default Blackday;
