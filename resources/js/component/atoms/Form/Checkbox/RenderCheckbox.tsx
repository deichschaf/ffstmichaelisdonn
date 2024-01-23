import React from 'react';
import { AllCheckboxProps } from '../../../../props/props';
import Checkbox from './Checkbox';

function toggleCheckbox() {
  return false;
}
const RenderCheckbox: React.FC<React.PropsWithChildren<AllCheckboxProps>> = (
  props: AllCheckboxProps,
) => (
  <fieldset>
    <legend className="sr-only">Checkbox</legend>
    <div className="checkbox-container">
      <Checkbox
        name={props.name}
        id={props.id}
        checked={props.checked}
        className="checkbox__input"
        onChange={toggleCheckbox}
        defaultValue={props.value}
      />
      <label htmlFor={props.id} />
    </div>
  </fieldset>
);

export default RenderCheckbox;
