import React from 'react';
import { FireDepartmentFieldTypeDataProps } from '../../../props/props';
import FireDepartmentFieldType from '../../atoms/FireDepartmentFieldType';
import H4 from '../../atoms/Typography/H4';
import ErrorBoundary from '../../organisms/errorboundary';

const FireDepartmentFieldTypeData: React.FC<
  React.PropsWithChildren<FireDepartmentFieldTypeDataProps>
> = (props: FireDepartmentFieldTypeDataProps): JSX.Element => (
  <ErrorBoundary>
    <H4 label={`Einsatzarten ${props.jahr}`} />
    <FireDepartmentFieldType color="red" percent={props.data.fire_alarm} name="Brand" />
    <FireDepartmentFieldType
      color="blue"
      percent={props.data.technical_alarm}
      name="Hilfeleistung"
    />
    <FireDepartmentFieldType color="yellow" percent={props.data.false_alarm} name="Fehlalarm" />
  </ErrorBoundary>
);
export default FireDepartmentFieldTypeData;
