import React from 'react';
import { LabelInputComponentProps } from '../../../../props/props';
import GridSimple from '../../../molecules/GridSimple';
import ErrorBoundary from '../../../organisms/errorboundary';
import LabelInput from '../LabelInput';

const GridLabelInput: React.FC<React.PropsWithChildren<LabelInputComponentProps>> = (
  props: LabelInputComponentProps,
): JSX.Element => (
  <ErrorBoundary>
    <GridSimple>
      <LabelInput
        className={props.className}
        labelClassName={props.labelClassName}
        label={props.label}
        name={props.name}
        value={props.value}
        setParentValue={props.setParentValue}
      />
    </GridSimple>
  </ErrorBoundary>
);
export default GridLabelInput;
