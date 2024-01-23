import React, { useState } from 'react';
import Select, { ActionMeta, OnChangeValue, StylesConfig } from 'react-select';
import classNames from 'classnames';
import { ReactSelectProps } from '../../../../props/props';

const SelectMultiFixed: React.FC<React.PropsWithChildren<ReactSelectProps>> = (
  props: ReactSelectProps,
): JSX.Element => {
  const [getValues, setValues] = useState([]);
  return (
    <Select
      isMulti
      name={props.name}
      options={props.options}
      className={classNames('selectBox', props.className)}
      value={getValues}
    />
  );
};

export default SelectMultiFixed;
