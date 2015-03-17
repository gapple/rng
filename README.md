RNG is a Drupal module for allowing a person to associate with an event.

Copyright (C) 2015 Daniel Phin (@dpi)

# License

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

# About

RNG is inspired by contributed Registration and Signup modules. Development
originally began early 2013, but has been reworked due to inactivity of the
original project, and unexpected extension of development timeline for Drupal 8.

See MAINTAINERS.txt for a list of official developers.

# Terms

 * Event: any content (fieldable) entity.
 * Registration type: bundle entity for Registrations.
 * Registration: an entity that associates with one Event, and has at least
   one child Registrant. Each Registration has at least one owner Registrant.
 * Registrant: an entity that maintains a relationship between a Registration
   and an Identity.
 * Identity: any entity that has implemented a method for contact, core 
   implements the User entity, although RNG provides another entity which is
   used for anonymous purposes.
 * EventTypeConfig: and entity maintaining configuration, and default values
   for EventConfig. Each EventTypeConfig is associated with an event bundle.
   This type exists pending [#2361775].

# Model

    Event ─┬─► Registration(s) ─┬─► Registrant(s) ─► Identity
           ├────────────────────┴─► Group(s)
           └─► Rule(s) ─┬─► Action(s)
                        └─► Condition(s)

A Registration is a fieldable entity that is associated with an Event entity,
and maintains relationships to Identities via Registrant entities.
Each Registrant holds the relationship between one Registration and one 
Identity. Registrant entities are fieldable, and thus can hold meta information
about how an Identity relates to a Registration.

# Usage

Please see the project websites for instructions:

 *  https://drupal.org/project/rng
 *  https://github.com/dpi/rng