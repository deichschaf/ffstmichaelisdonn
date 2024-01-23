import React from 'react';
import Select from 'react-select';
import classNames from 'classnames';
import { AllFormProps } from '../../../../props/props';

const SelectSingle: React.FC<React.PropsWithChildren<AllFormProps>> = (
  props: AllFormProps,
): JSX.Element => (
  <Select
    name={props.name}
    options={props.options}
    className={classNames('selectBox', props.className)}
  />
);

export default SelectSingle;
