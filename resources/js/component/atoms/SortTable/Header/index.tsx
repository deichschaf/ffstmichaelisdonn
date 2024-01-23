import React from 'react';
import { SortTableHeadline } from '../../../../props/props';
import ButtonFAS from '../../Buttons/ButtonFAS';
import H4 from '../../Typography/H4';

const SortTableHeader: React.FC<React.PropsWithChildren<SortTableHeadline>> = (
  props: SortTableHeadline,
): JSX.Element => (
  <div className="grid-title">
    <H4 label={props.lable} />
    {props.showTableButtons === true || typeof props.showTableButtons === 'undefined' ? (
      <div className="tools">
        <ButtonFAS className="chevron-down" />
        <ButtonFAS className="cogs" data-toggle="modal" />
        <ButtonFAS className="sync" />
        <ButtonFAS className="times" />
      </div>
    ) : (
      ''
    )}
  </div>
);

export default SortTableHeader;
