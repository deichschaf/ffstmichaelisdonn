import React from 'react';
import { ShowActiveProps } from '../../../../props/props';
import FAS from '../FAS';

const ShowActive: React.FC<React.PropsWithChildren<ShowActiveProps>> = (
  props: ShowActiveProps,
): JSX.Element => {
  if (props.active === 1 || props.active === '1' || props.active === true) {
    return <FAS className="square-check green" />;
  }
  return <FAS className="square" />;
};
export default ShowActive;
