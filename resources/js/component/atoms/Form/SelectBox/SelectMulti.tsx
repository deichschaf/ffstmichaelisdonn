import React from 'react';
import Select from 'react-select';
import classNames from 'classnames';
import { ReactSelectProps } from '../../../../props/props';

const SelectMulti: React.FC<React.PropsWithChildren<ReactSelectProps>> = (
  props: ReactSelectProps,
): JSX.Element => (
  // @ts-ignore
  <Select
    isMulti
    closeMenuOnSelect={props.closeMenuOnSelect}
    classNamePrefix="select"
    name={props.name}
    options={props.options}
    className={classNames('selectBox', props.className)}
  />
);

export default SelectMulti;
