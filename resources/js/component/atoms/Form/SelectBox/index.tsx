import React from 'react';
import Select from 'react-select';
import classNames from 'classnames';

export interface SelectOption {
  display: string;
  value: string;
}

export interface SelectBoxProps {
  className?: string;
  onChange?: (event?: React.MouseEvent<HTMLSelectElement, MouseEvent>) => void;
  onClick?: (event?: React.MouseEvent<HTMLSelectElement, MouseEvent>) => void | undefined;
  label: string;
  options: SelectOption[];
  selected?: string;
}

const SelectBox: React.FC<SelectBoxProps> = (props: SelectBoxProps): JSX.Element => (
  <Select
    isMulti
    name={props.label}
    options={props.options}
    className={classNames('selectBox', props.className)}
  />
);

export default SelectBox;
