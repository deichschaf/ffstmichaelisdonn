import React from 'react';
import { IProps } from '../../../../props/props';

const Checkbox: React.FunctionComponent<React.PropsWithChildren<IProps>> = (props: IProps) => {
  let shared;
  return <input onChange={e => props.onChange(e.target.checked)} {...shared} />;
};

Checkbox.defaultProps = {
  type: 'checkbox',
};
export default Checkbox;
