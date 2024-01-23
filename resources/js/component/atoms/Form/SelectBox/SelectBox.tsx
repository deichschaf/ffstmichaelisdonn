import React from 'react';
import Select from 'react-select';
import classNames from 'classnames';
import { SelectBoxProps } from '../../../../props/props';

const SelectBox: React.FC<React.PropsWithChildren<SelectBoxProps>> = (
  props: SelectBoxProps,
): JSX.Element => (
  <Select
    isMulti
    name={props.label}
    options={props.options}
    className={classNames('selectBox', props.className)}
  />
);

export default SelectBox;
