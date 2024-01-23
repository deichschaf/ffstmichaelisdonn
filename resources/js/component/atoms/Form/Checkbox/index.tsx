import React from 'react';
import classNames from 'classnames';

export interface CheckboxProps
  extends Omit<React.InputHTMLAttributes<HTMLInputElement>, 'onChange'> {
  onChange(value: boolean): void;
  className?: string;
  onClick: (event?: React.MouseEvent<HTMLInputElement>) => void;
  label?: string;
}

const Checkbox: React.FC<React.PropsWithChildren<CheckboxProps>> = (props: CheckboxProps) => (
  <input
    className={classNames('Checkbox', props.className)}
    onChange={e => props.onChange(e.target.checked)}
  />
);
export default Checkbox;
